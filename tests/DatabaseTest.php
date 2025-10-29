<?php
/*
| ======================================================================================================
| Name          : Database Test
| Description   : To test the session connection
| Requirements  : test_requirement.php
|
| Created by    : Michael Christopher Otniel Wijanto
| Creation Date : 2025-06-02
| Version       : 1.0.0
|
| Modifications:
|       - v1.0.1 - [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/

namespace Test;

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../michael_ch/core/src/implementation/test_requirement.php';


class DatabaseTest extends TestCase
{
    public function testGetConnection()
    {
        $connection = doctrine()->getConnection();
        self::assertNotNull($connection);
    }

    public function testConnectionSingleton()
    {
        $connection1 = doctrine()->getConnection();
        $connection2 = doctrine()->getConnection();
        self::assertSame($connection1, $connection2);
    }
}