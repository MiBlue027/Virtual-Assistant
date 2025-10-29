<?php

namespace support;

use Exception;

class ManifestReader
{
    /**
     * @throws Exception
     */
    public static function GET_MANIFEST($entry): string
    {
        $manifestPath = __DIR__ . '/../../../../public/src/style-js/.vite/manifest.json';
        $manifest = json_decode(file_get_contents($manifestPath), true);

        if (!isset($manifest[$entry])) {
            throw new Exception("Entry '$entry' not found in manifest");
        }

        return '/src/style-js/' . $manifest[$entry]['file'];
    }
}