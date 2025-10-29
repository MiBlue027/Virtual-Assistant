<?php

namespace Database\Entities;

use App\Enum\EntityEnum\EUser_UserStat;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use support\session\SessionService;

#[Entity]
#[HasLifecycleCallbacks]
#[Table(name: 'users')]
class Users
{
    #region PROPERTIES
    #[Id]
    #[Column(name: "USERS_ID", type: Types::BIGINT, nullable: false), GeneratedValue()]
    private int $usersId;
    #[Column(name: "USERNAME", type: Types::STRING, length: 50, unique: true, nullable: false)]
    private string $username;
    #[Column(name: "USER_EMAIL", type: Types::STRING, length: 255, unique: true, nullable: true)]
    private ?string $userEmail;
    #[Column(name: "PASSWORD",type: Types::STRING, length: 255, nullable: false)]
    private string $password;
    #[Column(name: "ATTEMPT_COUNT", type: Types::INTEGER, nullable: false)]
    private int $attemptCount;
    #[Column(name: "IS_LOCK", type: Types::BOOLEAN, nullable: false)]
    private bool $isLock;
    #endregion

    #region RELATION
    #[OneToOne(targetEntity: UserProfile::class, mappedBy: "users", cascade: ["persist"])]
    private ?UserProfile $userProfile;
    #[OneToMany(targetEntity: RefUser::class, mappedBy: "users", cascade: ["persist"])]
    private Collection $refUser;


    public function __construct()
    {
        $this->refUser = new ArrayCollection();

        $this->attemptCount = 0;
        $this->isLock = false;
    }

    public function getUserProfile(): UserProfile
    {
        return $this->userProfile;
    }

    public function addUserProfile(UserProfile $userProfile): void
    {
        $this->userProfile = $userProfile;
        $userProfile->setUsers($this);
    }

    public function removeUserProfile(UserProfile $userProfile): void
    {
        if ($this->userProfile != null){
            $oldUserProfile = $this->userProfile;
            $this->userProfile = null;

            if ($oldUserProfile->getUsers() === $this) {
                $oldUserProfile->setUsers(null);
            }
        }
    }

    public function getRefUser(): Collection
    {
        return $this->refUser;
    }

    public function addRefUser(RefUser $refUser): void
    {
        if (!$this->refUser->contains($refUser)) {
            $this->refUser->add($refUser);
            $refUser->setUsers($this);
        }
    }

    public function removeRefUser(RefUser $refUser): void
    {
        if ($this->refUser->removeElement($refUser)){
            if ($refUser->getUsers() === $this) {
                $refUser->setUsers(null);
            }
        }
    }


    #endregion

    #region GETTER_SETTER
    public function getUsersId(): int
    {
        return $this->usersId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function setUserEmail(?string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isLock(): bool
    {
        return $this->isLock;
    }

    public function setIsLock(bool $isLock): void
    {
        $this->isLock = $isLock;
    }

    public function getAttemptCount(): int
    {
        return $this->attemptCount;
    }

    public function setAttemptCount(int $attemptCount): void
    {
        $this->attemptCount = $attemptCount;
    }


    #endregion


}