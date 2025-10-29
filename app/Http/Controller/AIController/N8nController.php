<?php

namespace App\Http\Controller\AIController;

use App\Service\AIService\F5_TtsSvc;
use App\Service\AIService\GPT_SoVITSSvc;
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

            if ($isWithTTS){
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
                            "text" => $response['text'],
                            "html" => $response['html'],
                            "audio" => $audioUrl
                        ]
                    ]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'data' => [
                            "text" => $response['text'],
                            "html" => $response['html'],
                            "ref_audio" => __DIR__ . "/../../../../resources/ai/ref_audio/Kokomi-Fish.wav",
                            "ref_text"  => "Respect must be given to the will of every creature. Each fish in the ocean swims in its own direction.",
                            "gen_text"  => $response['text'],
                            "tts_endpoint" => "ws://127.0.0.1:9881/ws_tts"
                        ]
                    ]);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'data' => [
                        'text' => $response['text'],
                        "html" => $response['html']
                    ]
                ]);
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
}