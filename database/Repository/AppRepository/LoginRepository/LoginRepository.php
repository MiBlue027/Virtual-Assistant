<?php

namespace Database\Repository\AppRepository\LoginRepository;

use Database\Entities\Users;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Parameter;

class LoginRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetAdminByUsername(string $username): ?Users
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u')
            ->from(Users::class, 'u')
            ->where('u.username = :username ')
            ->setParameters( new ArrayCollection(array(
                    new Parameter('username', $username),
                ))
            );

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function LoginFailed(Users $user): void
    {
        $attemptCount = $user->getAttemptCount();
        $user->setAttemptCount($attemptCount + 1);
        repo_save();
    }

    public function LoginSuccess(Users $user): void
    {
        $user->setAttemptCount(0);
        repo_save();
    }
}
