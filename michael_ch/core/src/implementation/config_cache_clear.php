<?php
/*
| ======================================================================================================
| Name          : Config Cache Clear
| Description   : To clear all config cache using composer
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

$cacheFile =  __DIR__ . '/../../../../initiate/cache/config_cache.php';

if ($cacheFile && file_exists($cacheFile)) {
    unlink($cacheFile);
    echo "Config cache cleared.\n";
} else {
    echo "No config cache found.\n";
}
