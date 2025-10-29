<?php
/*
| ======================================================================================================
| Name          : Env
| Description   : To create environment variable
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

use Dotenv\Dotenv;
class Env
{
    protected static bool $loaded = false;

    private static function Load() : void
    {
        if (!self::$loaded) {
            $root = dirname(__DIR__, 4);
            $dotenv = Dotenv::createImmutable($root);
            $dotenv->load();
            self::$loaded = true;
        }
    }
    public static function Get(string $key, mixed $default = null) : mixed
    {
        if (!self::$loaded) {
            self::Load();
        }

        $value = $_ENV[$key] ?? getenv($key);

        if ($value === false) {
            return $default;
        }

        return match (strtolower($value)) {
            'true'  => true,
            'false' => false,
            'null'  => null,
            default => trim($value, "\"'"),
        };
    }
}