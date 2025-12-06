<?php

namespace App\Http\Controller\API;

use App\Service\API\ReceiveQuestionFromN8nSvc;
use Database\Repository\ApiRepository\RefQstSumRepository;
use Doctrine\ORM\EntityManager;

class QuestionSummaryController extends BaseController
{
    private EntityManager $entityManager;
    public function __construct()
    {
        $this->entityManager = doctrine();
    }
    function ReceiveQuestionFromN8n()
    {
        try {
            $input = $this->input();

            $data = $this->validate($input, [
                "question" => [
                    "required",
                    "type" => "string"
                ]
            ]);

            $question = $data['question'];

            $refQstSumRepository = new RefQstSumRepository($this->entityManager);
            $service = new ReceiveQuestionFromN8nSvc($refQstSumRepository);

            $isSuccess = $service->SaveQuestion($question);

            if ($isSuccess) {
                return $this->json([
                    "success" => true,
                    "question" => $data["question"]
                ]);
            } else {
                return $this->json([
                    "success" => false,
                    "question" => $data["question"],
                    "message" => "Failed to save question"
                ]);
            }
        } catch (\Exception $exception) {
            return $this->json([
                "success" => false,
                "message" => $exception->getMessage()
            ]);
        }

    }

    function ReceiveNTFQuestionFromN8n()
    {
        try {
            $input = $this->input();

            $data = $this->validate($input, [
                "question" => [
                    "required",
                    "type" => "string"
                ]
            ]);

            $question = $data['question'];

            $refQstSumRepository = new RefQstSumRepository($this->entityManager);
            $service = new ReceiveQuestionFromN8nSvc($refQstSumRepository);

            $isSuccess = $service->SaveNTFQuestion($question);

            if ($isSuccess) {
                return $this->json([
                    "success" => true,
                    "question" => $data["question"]
                ]);
            } else {
                return $this->json([
                    "success" => false,
                    "question" => $data["question"],
                    "message" => "Failed to save question"
                ]);
            }
        } catch (\Exception $exception) {
            return $this->json([
                "success" => false,
                "message" => $exception->getMessage()
            ]);
        }
    }
}