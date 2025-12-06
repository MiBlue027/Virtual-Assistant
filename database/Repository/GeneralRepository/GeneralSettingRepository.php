<?php

namespace Database\Repository\GeneralRepository;

use Database\Entities\GeneralSetting;
use Doctrine\ORM\EntityManager;

class GeneralSettingRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetGSByGsCode(string $code): ?GeneralSetting
    {
        return $this->entityManager->getRepository(GeneralSetting::class)->findOneBy(['gsCode' => $code]);
    }
}