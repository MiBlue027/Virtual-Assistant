<?php

namespace Database\Entities;

use App\Enum\EntityEnum\GeneralEnum\EGender;
use Database\Entities\Trait\Timestampable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[HasLifecycleCallbacks]
#[Table(name: 'user_profile')]
class UserProfile
{
    #region PROPERTIES
    #[Id]
    #[Column(name: "USER_PROFILE_ID", type: Types::BIGINT, nullable: false), GeneratedValue]
    private int $userProfileId;
    #[Column(name: "FULL_NAME", type: Types::STRING, length: 150, nullable: false)]
    private string $fullName;
    #[Column(name: "GENDER", type: Types::STRING, length: 1, nullable: false)]
    private string $gender;
    #[Column(name: "BIRTH_DT", type: Types::DATE_MUTABLE, length: 50, nullable: true)]
    private ?DateTimeInterface $birthDt;
    #[Column(name: "PHONE", type: Types::STRING, length: 25, nullable: true)]
    private ?string $phone;
    #[Column(name: "ADDRESS", type: Types::STRING, length: 150, nullable: true)]
    private ?string $address;
    #[Column(name: "CITY", type: Types::STRING, length: 50, nullable: true)]
    private ?string $city;
    #[Column(name: "RT", type: Types::STRING, length: 3, nullable: true)]
    private ?string $rt;
    #[Column(name: "RW", type: Types::STRING, length: 3, nullable: true)]
    private ?string $rw;
    #[Column(name: "ZIP_CODE", type: Types::INTEGER, nullable: true)]
    private ?int $zipCode;
    #endregion
    #region RELATION
    #[OneToOne(targetEntity: Users::class, inversedBy: "userProfile")]
    #[JoinColumn(name: "USERS_ID", referencedColumnName: "USERS_ID", onDelete: "CASCADE")]
    private ?Users $users;

    public function __construct()
    {
        $this->users = null;

        $this->birthDt = null;
        $this->phone = null;
        $this->address = null;
        $this->city = null;
        $this->rt = null;
        $this->rw = null;
        $this->zipCode = null;
    }
    #endregion

    #region GETTER SETTER
    public function getUserProfileId(): int
    {
        return $this->userProfileId;
    }
    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function getBirthDt(): ?DateTimeInterface
    {
        return $this->birthDt;
    }

    public function setBirthDt(?DateTimeInterface $birthDt): void
    {
        $this->birthDt = $birthDt;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getRt(): ?string
    {
        return $this->rt;
    }

    public function setRt(?string $rt): void
    {
        $this->rt = $rt;
    }

    public function getRw(): ?string
    {
        return $this->rw;
    }

    public function setRw(?string $rw): void
    {
        $this->rw = $rw;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(?int $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): void
    {
        $this->users = $users;
    }

    #endregion
}