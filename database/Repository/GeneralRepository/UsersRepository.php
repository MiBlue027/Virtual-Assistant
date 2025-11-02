<?php

namespace Database\Repository\GeneralRepository;

use Database\Entities\Users;
use Doctrine\ORM\EntityManager;

class UsersRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetUsersById(int $id): ?Users
    {
        return $this->entityManager->getRepository(Users::class)->findOneBy(["usersId" => $id]);
    }

    public function GetUsersAdminById(int $usersId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u')
            ->from(Users::class, 'u')
            ->join('u.refUser', 'ru')
            ->join('ru.roles', 'r')
            ->where(
                'u.usersId = :usersId 
                AND ru.refUserStat = :ruStatACT
                AND r.roleCode != :roleCode
                AND r.isAct = :isACT')
            ->setParameter("usersId", $usersId)
            ->setParameter("ruStatACT", "ACT")
            ->setParameter("roleCode", "GST")
            ->setParameter("isACT", true);

        return $qb->getQuery()->getOneOrNullResult();
    }
}