<?php

namespace Database\Repository\AppRepository\AdminRepository;

use App\Enum\EntityEnum\EUser_UserStat;
use Database\Entities\Users;
use Doctrine\ORM\EntityManager;

class UserManagementRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetUsersList(): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u.usersId AS usersId', 'u.username AS username', 'u.userEmail AS userEmail', 'u.userStat AS userStat', 'up.fullName AS fullName', 'pu.username AS registerBy', 'u.dtmCrt AS registerDt')
            ->from(Users::class, 'u')
            ->join('u.parentUser', 'pu')
            ->join('u.userProfile', 'up')
            ->where('u.userStat != :userStat')
            ->setParameter('userStat', EUser_UserStat::CANCEL);
        return $qb->getQuery()->getResult();
    }

}