<?php

namespace Database\Repository\GeneralRepository;

use Database\Entities\RefUser;
use Doctrine\ORM\EntityManager;

class RefUserRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetUserRoleByUsersId(int $usersId): ?array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u.usersId AS usersId'
                , 'u.username AS username'
                , 'r.rolesId AS rolesId'
                , 'r.roleName AS roleName'
                , 'r.roleCode AS roleCode'
                , 'r.roleLvl AS roleLvl'
                , 'ru.refUserStat AS refUserStat')
            ->from(RefUser::class, 'ru')
            ->join('ru.users', 'u')
            ->join('ru.roles', 'r')
            ->where('u.usersId = :usersId')
            ->setParameter('usersId', $usersId);

        return $qb->getQuery()->getResult();
    }
}