<?php

namespace Database\Repository\ApiRepository;

use Database\Entities\RefQstSum;
use Doctrine\ORM\EntityManager;

class RefQstSumRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetRefQtySumByQuestion(string $question) : ?RefQstSum
    {
        return $this->entityManager->getRepository(RefQstSum::class)->findOneBy(["question" => $question]);
    }

    public function GetKnowledgeQuestion(?int $limit = null) : ?array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('rqs')
            ->from(RefQstSum::class, 'rqs')
        ->where('rqs.isNTF = :isNTF')
        ->setParameter('isNTF', 0)
        ->orderBy('rqs.qty', 'DESC');
        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }
        return $qb->getQuery()->getArrayResult();
    }

    public function GetUnknowledgeQuestion(?int $limit = null) : ?array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('rqs')
            ->from(RefQstSum::class, 'rqs')
            ->where('rqs.isNTF = :isNTF')
            ->setParameter('isNTF', 1)
            ->orderBy('rqs.qty', 'DESC');
        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }
        return $qb->getQuery()->getArrayResult();
    }
}