<?php
/*
| ======================================================================================================
| Name          : Doctrine
| Description   : To create entityManager
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
namespace support;
use App\Exception\AppException;
use App\Exception\ExceptionCode;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class Doctrine
{
    private static ?EntityManager $entityManager = null;

    /**
     * @throws AppException
     */
    public static function GET(): EntityManager
    {
        if (self::$entityManager !== null) {
            return self::$entityManager;
        }

        $paths = [__DIR__ . '/../../../../database/Entity'];
        $isDevMode = true;

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $paths,
            isDevMode: $isDevMode,
        );

        if (env("ENV") === "prod") {
            $conn = [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'dbname' => env('DB_DATABASE'),
                'user' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'charset' => 'utf8mb4'
            ];
        } elseif (env("ENV") === "dev") {
            $conn = [
                'driver' => env('DB_DRIVER_DEV'),
                'host' => env('DB_HOST_DEV'),
                'port' => env('DB_PORT_DEV'),
                'dbname' => env('DB_DATABASE_DEV'),
                'user' => env('DB_USERNAME_DEV'),
                'password' => env('DB_PASSWORD_DEV'),
                'charset' => 'utf8mb4'
            ];
        } else{
            throw new AppException(ExceptionCode::DATABASE_UNKNOWN_ENV);
        }

        $connection = DriverManager::getConnection($conn, $config);
        self::$entityManager = new EntityManager($connection, $config);
        return self::$entityManager;
    }
}