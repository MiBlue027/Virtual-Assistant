<?php
/*
| ======================================================================================================
| Name          : Loader
| Description   : To load static function once time
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

use Doctrine\ORM\EntityManager;
use JetBrains\PhpStorm\NoReturn;
use support\Config;
use support\Doctrine;
use support\Encryption;
use support\Env;
use support\Key;
use support\ManifestReader;
use support\Repository;
use support\View;

if (! function_exists("app_key")){
    function app_key(): string
    {
        return Key::GET_APP_KEY();
    }
}

if (! function_exists("config")){
    function config($key, $default = null)
    {
        return Config::Get($key, $default);
    }
}

if (! function_exists("decrypt")){
    function decrypt($encrypted): string
    {
        try {
            return Encryption::DECRYPT($encrypted);
        }catch (Exception $e){
            return $e->getMessage();
        }

    }
}

if (! function_exists("decrypt_pass")){
    function decrypt_pass($encrypted): string
    {
        try {
            return Encryption::DECRYPT_PASS($encrypted);
        }catch (Exception $e){
            return $e->getMessage();
        }

    }
}

if (! function_exists("doctrine")){
    function doctrine(): EntityManager
    {
        return Doctrine::GET();
    }
}

if (! function_exists("encrypt")){
    function encrypt(string $value): string
    {
        return Encryption::ENCRYPT($value);
    }
}

if (! function_exists("encrypt_pass")){
    function encrypt_pass(string $value): string
    {
        return Encryption::ENCRYPT_PASS($value);
    }
}

if (! function_exists("env")){
    function env($key, $default = null)
    {
        return Env::get($key, $default);
    }
}

if (! function_exists("pass_key")){
    function pass_key(): string
    {
        return Key::GET_PASS_KEY();
    }
}


if (! function_exists("redirect")){
    #[NoReturn] function redirect(string $url): void
    {
        View::REDIRECT($url);
    }
}

if (! function_exists("repo_delete")){
    function repo_delete($entity): bool
    {
        return Repository::DELETE($entity);
    }
}

if (! function_exists("repo_save")){
    function repo_save($entity = null): bool
    {
        try {
            return Repository::SAVE($entity);
        } catch (Exception $e){
            return false;
        }
    }
}

if (! function_exists("secret_key")){
    function secret_key(): string
    {
        return Key::GET_SECRET_KEY();
    }
}

if (! function_exists("view")){
    function view($view, $model): void
    {
        View::RENDER($view, $model);
    }
}

if (! function_exists("vite_manifest")){
    /**
     * @throws Exception
     */
    function vite_manifest($entry): string
    {
        return ManifestReader::GET_MANIFEST($entry);
    }
}


