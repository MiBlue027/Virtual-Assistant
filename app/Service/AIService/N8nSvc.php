<?php

namespace App\Service\AIService;

use Database\Entities\RefDoc;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class N8nSvc
{
    private string $n8nWebhookUrl;
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->n8nWebhookUrl = env("N8N_API_KEY");
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

    public function UploadDoc(array $file)
    {
        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Format file tidak diizinkan.");
        }

        $refDoc = new RefDoc();
        $refDoc->setDocName($file["name"]);
        $refDoc->setDocStat("ACT");
        $refDoc->setDocPath("/resources/document/{$file["name"]}");

        $webhookUrl = env("N8N_KNOWLEDGE_API_KEY");

        $client = new Client();

        try {
            $response = $client->post($webhookUrl, [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($file['tmp_name'], 'r'),
                        'filename' => $file['name'],
                        'headers'  => [
                            'Content-Type' => $file['type']
                        ]
                    ],
                ],
                'timeout' => 30,
            ]);

            $status = $response->getStatusCode();
            $body   = $response->getBody()->getContents();


            return [
                'success' => ($status === 200 || $status === 201),
                'message' => 'Upload successful',
                'response' => $body
            ];

        } catch (RequestException $e) {
            $errorMsg = $e->hasResponse()
                ? $e->getResponse()->getBody()->getContents()
                : $e->getMessage();

            return [
                'success' => false,
                'message' => 'Upload failed: ' . $errorMsg,
                'response' => null
            ];
        }
    }
}