<?php

namespace Database\Repository\MiddlewareRepository;

use App\Enum\EntityEnum\ERefUser_RefUSerStat;
use App\Enum\EntityEnum\ERoles_RoleName;
use App\Enum\EntityEnum\EUser_UserStat;
use Database\Entities\Users;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Parameter;

class AdminOnlyRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetAdminByUserId(int $userId): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u')
            ->from(Users::class, 'u')
            ->join('u.refUser', 'ru')
            ->join('u.emp', 'e')
            ->join('ru.roles', 'r')
            ->where(
                'u.usersId = :usersId 
                AND (u.userStat = :statNEW OR u.userStat = :statACT)
                AND ru.refUserStat = :ruStatACT
                AND r.roleName != :roleName
                AND r.isAct = :isACT')
            ->setParameter("usersId", $userId)
            ->setParameter("statNEW", EUser_UserStat::NEW)
            ->setParameter("statACT", EUser_UserStat::ACTIVE)
            ->setParameter("ruStatACT", ERefUser_RefUSerStat::ACTIVE)
            ->setParameter("roleName", ERoles_RoleName::MEMBER)
            ->setParameter("isACT", true);

        return $qb->getQuery()->getResult();
    }
}