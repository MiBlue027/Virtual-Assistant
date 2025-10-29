<?php

namespace App\Service\AIService;

use GuzzleHttp\Client;

class F5_TtsSvc
{
    private Client $client;

    public function __construct() {
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:9881',
            'timeout'  => 120,
        ]);
    }

    public function GenerateTts(string $message, string $refAudio, string $refText): string {
        $outputPath = __DIR__ . '/../../../public/tts/f5tts_' . time() . '.wav';

        $this->client->request('POST', '/tts', [
            'json' => [
                'ref_audio' => $refAudio,
                'ref_text'  => $refText,
                'gen_text'  => $message
            ],
            'sink' => $outputPath
        ]);

        return '/tts/' . basename($outputPath);
    }

//    public function StreamTts(string $message, string $refAudio, string $refText): void
//    {
//        header('Content-Type: audio/x-raw');
//        header('Cache-Control: no-cache');
//
//        $client = new Client([
//            'base_uri' => 'http://127.0.0.1:9881',
//            'timeout'  => 0,
//            'stream'   => true,
//        ]);
//
//        $response = $client->post('/ws_tts', [
//            'json' => [
//                'ref_audio' => $refAudio,
//                'ref_text'  => $refText,
//                'gen_text'  => $message
//            ],
//            'stream' => true
//        ]);
//
//        $body = $response->getBody();
//        while (!$body->eof()) {
//            echo $body->read(8192);
//            flush();
//        }
//    }

}