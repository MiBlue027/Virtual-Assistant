<?php

namespace Database\Repository\MiddlewareRepository;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;

class RoleValidationRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws Exception
     */
    public function MustValidRole(string $path, string $method, int $userId): int
    {
        $conn = $this->entityManager->getConnection();

        $sql = "CALL spGet_MustValidRole(:Path, :method, :userId, @res)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":Path", $path);
        $stmt->bindValue(":method", $method);
        $stmt->bindValue(":userId", $userId);
        $stmt->executeStatement();

        return $conn->fetchOne("SELECT @res");
    }

    /**
     * @throws Exception
     */
    public function MustHigherRole(string $path, string $method, int $userId): int
    {
        $conn = $this->entityManager->getConnection();

        $sql = "CALL spGet_MustHigherRole(:Path, :method, :userId, @res)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":Path", $path);
        $stmt->bindValue(":method", $method);
        $stmt->bindValue(":userId", $userId);
        $stmt->executeStatement();

        return $conn->fetchOne("SELECT @res");
    }

}