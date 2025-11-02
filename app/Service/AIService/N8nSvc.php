<?php

namespace App\Service\AIService;

use Database\Entities\RefDoc;
use Database\Repository\AppRepository\RefDocRepository;
use Doctrine\ORM\EntityManager;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class N8nSvc
{
    private string $n8nWebhookUrl;
    protected Client $client;
    private EntityManager $entityManager;

    public function __construct()
    {
        $this->client = new Client();
        $this->n8nWebhookUrl = env("N8N_API_KEY");
        $this->entityManager = doctrine();
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function sendMessageToN8n(string $message): array
    {
        $response = $this->client->post($this->n8nWebhookUrl, [
            'json' => [
                'users_id' => $_SESSION["usersId"],
                'message' => $message
            ],
            'timeout' => 30
        ]);

        $body = $response->getBody()->getContents();

        $responseData = json_decode($body, true);

        if (!isset($responseData['output'])) {
            throw new \Exception("Invalid response format from n8n: " . $body);
        }

        $rawText = $responseData['output'];
        $formatted = $this->formatAiText($rawText);

        return [
            'text' => $rawText,
            'html' => $formatted
        ];
    }

    private function formatAiText(string $text): string
    {
        $text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<i>$1</i>', $text);
        $text = nl2br($text);
        return htmlspecialchars_decode($text, ENT_QUOTES);
    }

    public function UploadDoc(array $file): void
    {
        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Please upload pdf / doc file");
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload error");
        }

        $uploadDir = __DIR__."/../../../resources/document/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;


        $refDocRepository = new RefDocRepository($this->entityManager);
        $isExist = !($refDocRepository->GetRefDocAct($fileName) == null);

        if ($isExist) {
            throw new Exception("Document already exist");
        }

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Gagal menyimpan file ke direktori tujuan.");
        }

        try {
            $dbPath = "/resources/document/";
            $refDoc = new RefDoc();
            $refDoc->setDocName($file["name"]);
            $refDoc->setDocType($file["type"]);
            $refDoc->setDocStat("ACT");
            $refDoc->setDocPath($dbPath);
            repo_save($refDoc);
        } catch (Exception $exception) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            throw new Exception("Failed save document");
        }
    }

    public function DeleteDoc(string $docId): void
    {
        $refDocRepository = new RefDocRepository($this->entityManager);
        try {
            $intDocId = (int)$docId;
        } catch (Exception $exception) {
            throw new Exception("Failed delete document, please contact your administrator.");
        }

        $refDoc = $refDocRepository->GetRefDocById($intDocId);
        if ($refDoc == null) {
            throw new Exception("Failed delete document, please contact your administrator.");
        }

        $refDoc->setDocStat("DEL");
        repo_save();
    }


    public function GetAllActDoc(): ?array
    {
        $refDocRepo = new RefDocRepository($this->entityManager);
        return $refDocRepo->GetAllActRefDoc();
    }

    public function GetDocById(string $docId): ?RefDoc
    {
        $refDocRepository = new RefDocRepository($this->entityManager);
        try {
            $intDocId = (int)$docId;
        } catch (Exception $exception) {
            throw new Exception("Failed delete document, please contact your administrator.");
        }
        return $refDocRepository->GetRefDocById($intDocId);
    }
    public function ActivateDoc()
    {
        $webhookUrl = env("N8N_KNOWLEDGE_API_KEY", null);
        if ($webhookUrl == null) {
            return [
                'success' => false,
                'message' => "Error on agent service, please contact your administrator.",
                'results' => []
            ];
        }
        $docs = $this->GetAllActDoc();

        if (empty($docs)) {
            return [
                'success' => false,
                'message' => 'No active documents found in database.',
                'results' => []
            ];
        }

        $client = new Client(['timeout' => 30]);
        $results = [];
        $allSuccess = true;

        foreach ($docs as $doc) {
            $filePath = __DIR__ . "/../../../resources/document/" . $doc->getDocName();

            if (!file_exists($filePath)) {
                $results[] = [
                    'doc' => $doc->getDocName(),
                    'success' => false,
                    'message' => 'File not found: ' . $filePath
                ];
                $allSuccess = false;
                continue;
            }

            try {
                $response = $client->post($webhookUrl, [
                    'multipart' => [
                        [
                            'name'     => 'file',
                            'contents' => fopen($filePath, 'r'),
                            'filename' => basename($filePath),
                            'headers'  => [
                                'Content-Type' => mime_content_type($filePath)
                            ]
                        ],
                    ],
                ]);

                $status = $response->getStatusCode();
                $body   = $response->getBody()->getContents();

                $results[] = [
                    'doc' => $doc->getDocName(),
                    'success' => ($status === 200 || $status === 201),
                    'message' => "Uploaded successfully (" . $status . ")",
                    'response' => $body
                ];

                if (!($status === 200 || $status === 201)) {
                    $allSuccess = false;
                }

            } catch (RequestException $e) {
                $errorMsg = $e->hasResponse()
                    ? $e->getResponse()->getBody()->getContents()
                    : $e->getMessage();

                $results[] = [
                    'doc' => $doc->getDocName(),
                    'success' => false,
                    'message' => 'Upload failed: ' . $errorMsg
                ];

                $allSuccess = false;
            }
        }

        if ($allSuccess) {
            $message = "✅ All " . count($docs) . " document(s) uploaded successfully.";
        } else {
            $failedDocs = array_filter($results, fn($r) => !$r['success']);
            $successDocs = array_filter($results, fn($r) => $r['success']);

            $message = "Some documents failed to upload.<br />";
            $message .= count($successDocs) . " succeeded, " . count($failedDocs) . " failed.<br /><br />";

            foreach ($failedDocs as $fail) {
                $message .= "- " . htmlspecialchars($fail['doc']) . ": " . htmlspecialchars($fail['message']) . "<br />";
            }
        }

        return [
            'success' => $allSuccess,
            'message' => $message,
            'results' => $results
        ];
    }


}