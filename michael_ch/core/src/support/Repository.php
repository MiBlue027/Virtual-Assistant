<?php

namespace support;
/*
| ======================================================================================================
| Name          : Repository
| Description   : To create session repository
| Requirements  : None
|
| Created by    : Michael Christopher Otniel Wijanto
| Creation Date : 2025-06-02
| Version       : 1.0.0
|
| Modifications:
|       - v1.0.1 - [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/

use App\Exception\AppException;
use App\Exception\ExceptionCode;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Repository
{
    /**
     * @throws AppException
     */
    public static function SAVE(array|object|null $entity = null): bool
    {
        $entityManager = Doctrine::GET();
        try {
            $entityManager->beginTransaction();
            if ($entity !== null) {
                $entityList = is_array($entity) ? $entity : [$entity];

                foreach ($entityList as $entity) {
                    if (!is_object($entity)) {
                        throw new AppException(ExceptionCode::ENTITY_INVALID_ARGUMENT);
                    }

                    $classMetadata = $entityManager->getClassMetadata(get_class($entity));
                    $identifier = $classMetadata->getIdentifierValues($entity);

                    $isNew = empty($identifier) || !$entityManager->contains($entity);

                    if ($isNew) {
                        $entityManager->persist($entity);
                    }
                }
            }
            $entityManager->flush();
            $entityManager->commit();
            return true;
        } catch(OptimisticLockException|ORMException|\Exception $e) {
            echo $e->getMessage();
            $entityManager->rollback();
            return false;
        }
    }

    /**
     * @throws AppException
     */
    public static function DELETE($entity): bool
    {
        $entityManager = Doctrine::GET();
        try {
            $entityManager->beginTransaction();
            $entityManager->remove($entity);
            $entityManager->flush();
            $entityManager->commit();
            return true;
        } catch(OptimisticLockException|ORMException $e) {
            $entityManager->rollback();
            return false;
        }
    }
}