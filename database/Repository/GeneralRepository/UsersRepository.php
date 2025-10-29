<?php

namespace Database\Repository\GeneralRepository;

use App\Enum\EntityEnum\EUser_UserStat;
use Database\Entities\Users;
use Doctrine\ORM\EntityManager;

class UsersRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function GetAllUser(): ?array
    {
        return $this->entityManager->getRepository(Users::class)->findAll();
    }
    public function GetUserByUsersId(int $userId): ?Users
    {
        return $this->entityManager->getRepository(Users::class)->findOneBy(['usersId' => $userId]);
    }

    public function GetUserByUsername(string $username): ?Users
    {
        return $this->entityManager->getRepository(Users::class)->findOneBy(['username' => $username]);
    }

    public function GetUserByUserEmail(string $email): ?Users
    {
        return $this->entityManager->getRepository(Users::class)->findOneBy(['userEmail' => $email]);
    }

    public function GetNotCanceledUser(): ?array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u')
            ->from(Users::class, 'u')
            ->where('u.userStatus != :status')
            ->setParameter('status', EUser_UserStat::CANCEL->value);
        return $qb->getQuery()->getResult();
    }
}