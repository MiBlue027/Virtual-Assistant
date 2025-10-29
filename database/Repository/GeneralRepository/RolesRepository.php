<?php

namespace Database\Repository\GeneralRepository;

use App\Enum\EntityEnum\ERoles_RoleName;
use Database\Entities\Roles;
use Doctrine\ORM\EntityManager;

class RolesRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function GetAllRoles(): ?array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('r')
            ->from(Roles::class, 'r')
            ->where('r.roleCode != :roleCode')
            ->orderBy('r.roleLvl', 'ASC')
            ->setParameter('roleCode', 'SU');
        return $qb->getQuery()->getResult();
    }

    public function GetAllAdminRole(): ?array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('r')
            ->from(Roles::class, 'r')
            ->where('r.roleCode != :roleCodeSu AND r.roleCode != :roleCodeMbr')
            ->orderBy('r.roleLvl', 'ASC')
            ->setParameter('roleCodeSu', ERoles_RoleName::SUPPER_USER)
            ->setParameter('roleCodeMbr', ERoles_RoleName::MEMBER);
        return $qb->getQuery()->getResult();
    }

    public function GetRoleByRolesId(int $roleId): ?Roles
    {
        return $this->entityManager->getRepository(Roles::class)->findOneBy(['rolesId' => $roleId]);
    }

    public function GetRoleByRoleName(string $roleName): ?Roles
    {
        return $this->entityManager->getRepository(Roles::class)->findOneBy(['roleName' => $roleName]);
    }

    public function GetRoleByRoleCode(string $roleCode): ?Roles
    {
        return $this->entityManager->getRepository(Roles::class)->findOneBy(['roleCode' => $roleCode]);
    }
}