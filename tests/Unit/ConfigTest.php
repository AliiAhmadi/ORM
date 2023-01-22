<?php

namespace Tests\Unit;

use Orm\Exceptions\ConfigFileNotFoundException;
use PHPUnit\Framework\TestCase;
use Orm\Helpers\Config;

class ConfigTest extends TestCase
{
    public function testGetFileContentsReturnsArray()
    {
        $config = Config::getFileContents("database");

        $this->assertIsArray($config);
    }

    public function testGetExactArrayFromConfig()
    {
        $config = Config::get("database", "pdo");

        $this->assertIsArray($config);
    }

    public function testCheckIsExceptionThrowIfFileNotFound()
    {
        $this->expectException(ConfigFileNotFoundException::class);

        $config = Config::getFileContents("thisFileNotExists");
    }

    public function testIsExceptionThrowInGetMethod()
    {
        $this->expectException(ConfigFileNotFoundException::class);

        $config = Config::get("databases", "pdo");
    }

    public function testIsNullReturnsFromGetMethodIfKeyNotExists()
    {
        $config = Config::get("database", "keyNotExists");

        $this->assertNull($config);
    }

    public function testExpectedDataReturnFromGetMethodIfEvryThingsOk()
    {
        $config = Config::get("database", "pdo");

        $expextedData = [
            "driver"      => "mysql",
            "host"        => "localhost",
            "database"    => "orm",
            "db_user"     => "root",
            "db_password" => ""
        ];

        $this->assertEquals($config, $expextedData);
    }
}
