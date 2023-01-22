<?php

namespace Tests\Unit;

use PDO;
use Orm\Exceptions\DatabaseConnectionException;
use Orm\Helpers\Config;
use PHPUnit\Framework\TestCase;
use Orm\Database\PDODatabaseConnection;
use Orm\Contracts\DatabaseConnectionInterface;
use Orm\Exceptions\IncorrectConfigInfoException;

class PDODatabaseConnectionTest extends TestCase
{
    public function testPDODatabaseConnectionImplementsDatabaseConnectionInterface()
    {
        $config = $this->getConfig();

        $pdoConnection = new PDODatabaseConnection($config);

        $this->assertInstanceOf(DatabaseConnectionInterface::class, $pdoConnection);
    }

    public function testPDOConnectMethodShouldBeConnectToDatabse()
    {
        $config = $this->getConfig();

        $pdoConnection = new PDODatabaseConnection($config);

        $pdoInstance = $pdoConnection->connect()->getConnection();

        $this->assertInstanceOf(PDO::class, $pdoInstance);
    }

    private function getConfig(): array
    {
        $config = Config::get("database", "pdo_testing");

        return $config;
    }

    public function testIfConfigBeIncorrectShouldExceptionThrow()
    {
        $this->expectException(DatabaseConnectionException::class);

        $config = array_merge($this->getConfig(), [
            "database" => "notCorrectDatabase"
        ]);


        $pdoConnection = new PDODatabaseConnection($config);

        $pdoConnection->connect();
    }

    public function testIsReturnedDataFromConnectMethodHasAnInstanceOfDatabaseConnection()
    {
        $config = $this->getConfig();

        $pdoConnection = new PDODatabaseConnection($config);

        $Instance = $pdoConnection->connect();

        $this->assertInstanceOf(PDODatabaseConnection::class, $Instance);
    }

    public function testThrowIncorrectConfigInfoExceptionIfSomeKeysInConfigNotBeAvailable()
    {
        $this->expectException(IncorrectConfigInfoException::class);

        $config =  [
            "host"        => "localhost",
            "database"    => "orm",
            "db_user"     => "root",
            "db_password" => ""
        ];
        $pdoConnection = new PDODatabaseConnection($config);
    }
}
