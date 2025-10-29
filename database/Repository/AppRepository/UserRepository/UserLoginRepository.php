<?php

namespace Database\Repository\AppRepository\UserRepository;

use App\Enum\EntityEnum\EUser_UserStat;
use Database\Entities\Users;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Parameter;

class UserLoginRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetUserByUsername(string $username): ?Users
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u')
            ->from(Users::class, 'u')
            ->join('u.mbr', 'm')
            ->where(
                'u.username = :username 
                AND (u.userStat = :statNEW OR u.userStat = :statACT OR u.userStat = :statINACT)')
            ->setParameters( new ArrayCollection(array(
                    new Parameter('username', $username),
                    new Parameter('statNEW', EUser_UserStat::NEW->value),
                    new Parameter('statACT', EUser_UserStat::ACTIVE->value),
                    new Parameter('statINACT', EUser_UserStat::INACTIVE->value),
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
        $user->setLastLogin(new DateTime());
        repo_save();
    }
}