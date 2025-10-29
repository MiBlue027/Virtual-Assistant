<?php

namespace Database\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;


#[Entity]
#[HasLifecycleCallbacks]
#[Table(name: 'ref_user')]
class RefUser
{
    #region PROPERTIES
    #[Id]
    #[Column(name: "REF_USER_ID", type: Types::BIGINT, nullable: false), GeneratedValue]
    private int $refUserId;
    #[Column(name: "REF_USER_STAT", type: Types::STRING, length: 5, nullable: false)]
    private string $refUserStat;
    #[Column(name: "DESCR", type: Types::STRING, length: 500, nullable: true)]
    private ?string $descr;

    #endregion

    #region RELATION
    #[ManyToOne(targetEntity: Users::class, cascade: ["persist"], inversedBy: "refUser")]
    #[JoinColumn(name: "USERS_ID", referencedColumnName: "USERS_ID", onDelete: "CASCADE")]
    private ?Users $users;

    #[ManyToOne(targetEntity: Roles::class, inversedBy: "refUser")]
    #[JoinColumn(name: "ROLES_ID", referencedColumnName: "ROLES_ID", onDelete: "CASCADE")]
    private ?Roles $roles;

    public function __construct()
    {
        $this->descr = null;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): void
    {
        $this->users = $users;
    }

    public function getRoles(): ?Roles
    {
        return $this->roles;
    }

    public function setRoles(?Roles $roles): void
    {
        $this->roles = $roles;
    }

    #endregion

    #region GETTER_SETTER
    public function getRefUserId(): int
    {
        return $this->refUserId;
    }

    public function getRefUserStat(): ERefUser_RefUSerStat
    {
        return $this->refUserStat;
    }

    public function setRefUserStat(ERefUser_RefUSerStat $refUserStat): void
    {
        $this->refUserStat = $refUserStat;
    }

    public function getDescr(): string
    {
        return $this->descr;
    }

    public function setDescr(string $descr): void
    {
        $this->descr = $descr;
    }
    #endregion

}