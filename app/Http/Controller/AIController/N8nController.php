<?php

namespace App\Http\Controller\AIController;

use App\Service\AIService\F5_TtsSvc;
use App\Service\AIService\N8nSvc;
use GuzzleHttp\Exception\GuzzleException;
use Path\RoutePath;

class N8nController
{
    public const FUNC_GET_RESPONSE_WITH_TTS = "get_response_with_tts";
    public const FUNC_GET_RESPONSE_WITHOUT_TTS = "get_response_without_tts";
    public const FUNC_GET_RESPONSE_WITH_STREAM_TTS = "get_response_with_stream_tts";
    public function get_response_with_tts(): void
    {
        $this->GetResponse(true);
    }

    public function get_response_without_tts(): void
    {
        $this->GetResponse();
    }

    public function get_response_with_stream_tts(): void
    {
        $this->GetResponse(true, true);
    }

    private function GetResponse(bool $isWithTTS = false, bool $isStream = false): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['message'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        try {
            $userMessage = $_POST['message'];
            $agentScv = new N8nSvc();
            $response = $agentScv->sendMessageToN8n(message: $userMessage);

            [$lang, $text] = explode('-', $response['text'], 2);

            [, $textHtml] = explode('-', $response['html'], 2);

            $lang     = trim($lang);
            $text     = trim($text);
            $textHtml = trim($textHtml);

            if (!in_array($lang, ['EN', 'ID'])) {
                echo json_encode([
                    'success' => true,
                    'data' => [
                        "text" => $text,
                        "html" => $textHtml
                    ],
                    "error" => "Error lang format"
                ]);
                return;
            }

            if ($isWithTTS){
                try {
                    $f5TtsSvc = new F5_TtsSvc();
                    $refText = "Respect must be given to the will of every creature. Each fish in the ocean swims in its own direction.";

                    if (!$isStream) {
                        $audioUrl = $f5TtsSvc->GenerateTts(
                            message: $response['text'],
                            refAudio: __DIR__ . "/../../../../resources/ai/ref_audio/Kokomi-Fish.wav",
                            refText: $refText
                        );

                        header('Content-Type: application/json');
                        echo json_encode([
                            'success' => true,
                            'data' => [
                                "text" => $text,
                                "html" => $textHtml,
                                "audio" => $audioUrl
                            ]
                        ]);
                        return;
                    } else {
                        if ($lang == "EN") {
                            header('Content-Type: application/json');
                            echo json_encode([
                                'success' => true,
                                'data' => [
                                    "text" => $text,
                                    "html" => $textHtml,
                                    "ref_audio" => __DIR__ . "/../../../../resources/ai/ref_audio/Kokomi-Fish.wav",
                                    "ref_text"  => "Respect must be given to the will of every creature. Each fish in the ocean swims in its own direction.",
                                    "gen_text"  => $response['text'],
                                    "tts_endpoint" => "ws://127.0.0.1:9881/ws_tts"
                                ]
                            ]);
                            return;
                        } else if ($lang == "ID"){
//                            header('Content-Type: application/json');
//                            echo json_encode([
//                                'success' => true,
//                                'data' => [
//                                    "text" => $text,
//                                    "html" => $textHtml,
//                                    "ref_audio" => __DIR__ . "/../../../../resources/ai/ref_audio/Kokomi-Fish.wav",
//                                    "language_id" => "ms",
//                                    "gen_text"  => $response['text'],
//                                    "tts_endpoint" => "ws://127.0.0.1:9882/ws_tts"
//                                ]
//                            ]);
                            $audioUrl = $this->generateElevenLabsTts($text);
                            header('Content-Type: application/json');
                            echo json_encode([
                                'success' => true,
                                'data' => [
                                    "text" => $text,
                                    "html" => $textHtml,
                                    "audio" => $audioUrl
                                ]
                            ]);
                            return;
                        }

                    }
                } catch (\Exception $e){
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'data' => [
                            "text" => $text,
                            "html" => $textHtml
                        ],
                        "error" => "The voice feature is currently under maintenance. please continue using the chat mode"
                    ]);
                    return;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'data' => [
                        "text" => $text,
                        "html" => $textHtml
                    ]
                ]);
                return;
            }

        } catch (GuzzleException $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Guzzle error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    private function generateElevenLabsTts(string $text): string
    {
        $apiUrl = env('ELEVENLAB_API') . "JaUVfDrFcfwGIsv8X2kN";
        $apiKey = env('ELEVENLAB_KEY');

        $client = new \GuzzleHttp\Client();

        $response = $client->post($apiUrl, [
            'headers' => [
                'xi-api-key' => $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'audio/mpeg'
            ],
            'json' => [
                'text' => $text,
                'model_id' => 'eleven_multilingual_v2',
                'voice_settings' => [
                    'stability' => 0.45,
                    'similarity_boost' => 0.75
                ]
            ]
        ]);

        $audioBinary = $response->getBody()->getContents();

        $fileName = 'elevenlabs_' . uniqid() . '.mp3';
        $savePath = __DIR__ . '/../../../../public/tts/' . $fileName;

        file_put_contents($savePath, $audioBinary);

        return '/tts/' . $fileName;
    }



}