<?php

namespace Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[HasLifecycleCallbacks]
#[Table(name: 'roles')]
class Roles
{
    #region PROPERTIES
    #[Id]
    #[Column(name: "ROLES_ID", type: Types::BIGINT, nullable: false), GeneratedValue]
    private int $rolesId;
    #[Column(name: "ROLE_NAME", type: Types::STRING, length: 45, nullable: false)]
    private string $roleName;
    #[Column(name: "ROLE_LVL", type: Types::INTEGER, nullable: true)]
    private ?int $roleLvl;
    #[Column(name: "ROLE_CODE", type: Types::STRING, length: 5, nullable: false)]
    private string $roleCode;
    #[Column(name: "IS_ACT", type: Types::BOOLEAN, nullable: false)]
    private bool $isAct;
    #endregion

    #region RELATION
    #[OneToMany(targetEntity: RefUser::class, mappedBy: "roles", cascade: ["persist"])]
    private Collection $refUser;

    public function __construct()
    {
        $this->refUser = new ArrayCollection();
        $this->pathRoleAccess = new ArrayCollection();
    }

    public function getRefUser(): Collection
    {
        return $this->refUser;
    }

    public function addRefUser(RefUser $refUser): void
    {
        if (!$this->refUser->contains($refUser)) {
            $this->refUser->add($refUser);
            $refUser->setRoles($this);
        }
    }

    public function removeRefUser(RefUser $refUser): void
    {
        if ($this->refUser->removeElement($refUser)){
            if ($refUser->getRoles() === $this) {
                $refUser->setRoles(null);
            }
        }
    }

    public function getPathRoleAccess(): Collection
    {
        return $this->pathRoleAccess;
    }

    public function addPathRoleAccess(PathRoleAccess $pathRoleAccess): void
    {
        if (!$this->pathRoleAccess->contains($pathRoleAccess)) {
            $this->pathRoleAccess->add($pathRoleAccess);
            $pathRoleAccess->setRoles($this);
        }
    }

    public function removePathRoleAccess(PathRoleAccess $pathRoleAccess): void
    {
        if ($this->pathRoleAccess->removeElement($pathRoleAccess)) {
            if ($pathRoleAccess->getRoles() === $this) {
                $pathRoleAccess->setRoles(null);
            }
        }
    }

    #endregion

    #region GETTER_SETTER
    public function getRolesId(): int
    {
        return $this->rolesId;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): void
    {
        $this->roleName = $roleName;
    }

    public function getRoleLvl(): int
    {
        return $this->roleLvl;
    }

    public function setRoleLvl(?int $roleLvl): void
    {
        $this->roleLvl = $roleLvl;
    }

    public function getRoleCode(): string
    {
        return $this->roleCode;
    }

    public function setRoleCode(string $roleCode): void
    {
        $this->roleCode = $roleCode;
    }

    public function isAct(): bool
    {
        return $this->isAct;
    }

    public function setIsAct(bool $isAct): void
    {
        $this->isAct = $isAct;
    }
    #endregion
}