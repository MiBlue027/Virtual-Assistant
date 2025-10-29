<?php

namespace Test;

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../michael_ch/core/src/implementation/test_requirement.php';
class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $originalValue = "Hello World";
        $encrypt = encrypt($originalValue);
        $decrypt = decrypt($encrypt);

        echo "Encrypted: $encrypt\n";
        echo "Decrypted: $decrypt\n";

        $this->assertEquals($originalValue, $decrypt);
    }

    public function testEncryptionPass()
    {
        $originalValue = "pass";
        $encrypt = encrypt_pass($originalValue);
        $decrypt = decrypt_pass($encrypt);

        echo "Encrypted: $encrypt\n";
        echo "Decrypted: $decrypt\n";

        $this->assertEquals($originalValue, $decrypt);
    }
}