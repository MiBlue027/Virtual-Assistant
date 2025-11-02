<?php

namespace Database\Repository\GeneralRepository;

use Database\Entities\RefDoc;
use Doctrine\ORM\EntityManager;

class RefDocRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetRefDocById(int $refDocId): ?RefDoc
    {
        return $this->entityManager->getRepository(RefDoc::class)->findOneBy(['refDocId' => $refDocId]);
    }

    public function GetRefDocAct(string $docName): ?RefDoc
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('rd')
            ->from(RefDoc::class, 'rd')
            ->where("rd.docName = :fileName AND rd.docStat = :docStat")
            ->setParameter("fileName", $docName)
            ->setParameter("docStat", "ACT");
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function GetAllActRefDoc(): ?array
    {
        return $this->entityManager->getRepository(RefDoc::class)->findBy(['docStat' => 'ACT']);
    }
}