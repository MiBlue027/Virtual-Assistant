<?php
/*
| ======================================================================================================
| Name          : Config
| Description   : To create config
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

class Config
{
    protected static $configs = [];
    protected static $loaded = false;

    public static function Get($key, $default = null)
    {
        if (!self::$loaded) {
            $cacheFile = __DIR__ . '/../../../../initiate/cache/config_cache.php';
            if (file_exists($cacheFile)) {
                self::$configs = require $cacheFile;
            }
            self::$loaded = true;
        }

        $segments = explode('.', $key);
        $value = self::$configs;

        foreach ($segments as $segment) {
            if (!isset($value[$segment])) return $default;
            $value = $value[$segment];
        }

        return $value;
    }
}
