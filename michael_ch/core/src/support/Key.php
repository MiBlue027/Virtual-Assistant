<?php

namespace support;

class Key
{
    public static function GET_APP_KEY()
    {
        $key = env("APP_KEY");
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        return $key;
    }
    public static function GET_SECRET_KEY()
    {
        $key = env("SECRET_KEY");
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        return $key;
    }

    public static function GET_PASS_KEY()
    {
        $key = env("PASS_KEY");
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        return $key;
    }
}