<?php

namespace App\Service\AppService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HomeSvc
{
    /**
     * @throws \Exception
     */
    public function GetTotalChatHist()
    {
        $client = new Client([
            'timeout' => 10,
        ]);

        $webhook = env("N8N_GET_TOTAL_CHAT_HIST_API_KEY");

        try {
            $response = $client->post($webhook);

            return json_decode($response->getBody(), true);

        } catch (GuzzleException $e) {
            throw new \Exception("Error");
        }
    }

    public function ClearAllChatHist(): void
    {
        $client = new Client([
            'timeout' => 10,
        ]);

        $webhook = env("N8N_CLEAR_CHAT_HIST_API_KEY");

        try {
            $client->post($webhook);
        } catch (GuzzleException $e) {
            throw new \Exception("Error");
        }
    }
}