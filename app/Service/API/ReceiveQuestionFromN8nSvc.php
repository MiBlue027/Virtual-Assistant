<?php

namespace App\Service\API;

use Database\Entities\RefQstSum;
use Database\Repository\ApiRepository\RefQstSumRepository;

class ReceiveQuestionFromN8nSvc
{
    private RefQstSumRepository $refQstSumRepository;
    public function __construct(RefQstSumRepository $refQstSumRepository)
    {
        $this->refQstSumRepository = $refQstSumRepository;
    }

    public function SaveQuestion($question): bool
    {
        try {
            $refQstSum = $this->refQstSumRepository->GetRefQtySumByQuestion($question);
            if ($refQstSum == null) {
                $newRefQstSum = new RefQstSum();
                $newRefQstSum->setQuestion($question);
                repo_save($newRefQstSum);
            } else {
                $questionQty = $refQstSum->getQty();
                $refQstSum->setQty($questionQty + 1);
                $refQstSum->setQstDt(new \DateTime());
                repo_save();
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }

    }

    public function SaveNTFQuestion($question): bool
    {
        try {
            $refQstSum = $this->refQstSumRepository->GetRefQtySumByQuestion($question);
            if ($refQstSum == null) {
                $newRefQstSum = new RefQstSum();
                $newRefQstSum->setIsNTF(true);
                $newRefQstSum->setQuestion($question);
                repo_save($newRefQstSum);
            } else {
                $questionQty = $refQstSum->getQty();
                $refQstSum->setQty($questionQty + 1);
                $refQstSum->setQstDt(new \DateTime());
                repo_save();
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}