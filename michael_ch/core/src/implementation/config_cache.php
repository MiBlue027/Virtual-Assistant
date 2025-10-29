<?php
/*
| ======================================================================================================
| Name          : Config Cache
| Description   : To make config cache using composer
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

$sourceDir = __DIR__ . '/../../../../config';
$cacheFile = __DIR__ . '/../../../../initiate/cache/config_cache.php';

$configs = [];

foreach (glob($sourceDir . '/*.php') as $file) {
    $key = basename($file, '.php');
    $configs[$key] = require $file;
}

$content = '<?php return ' . var_export($configs, true) . ';';

file_put_contents($cacheFile, $content);

echo "Config cache generated at: $cacheFile\n";
