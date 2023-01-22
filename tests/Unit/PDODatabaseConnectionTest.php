<?php

namespace Tests\Unit;

use PDO;
use Orm\Helpers\Config;
use PHPUnit\Framework\TestCase;
use Orm\Database\PDODatabaseConnection;
use Orm\Contracts\DatabaseConnectionInterface;

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
}
