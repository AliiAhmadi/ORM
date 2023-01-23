<?php

namespace Tests\Unit;

use Orm\Database\PDODatabaseConnection;
use Orm\Helpers\Config;
use PHPUnit\Framework\TestCase;
use Orm\Database\PDOQueryBuilder;

class PDOQueryBuilderTest extends TestCase
{
    public function testItCanCreateDataAndInsertThem()
    {
        $pdoConnection = new PDODatabaseConnection($this->getConfig());

        $queryBuilder = new PDOQueryBuilder($pdoConnection->connect());

        $data = [
            "full_name" => "Ali Ahmadi",
            "email" => "aliahmadi@gmail.com",
            "github_profile" => "https://github/aliiahmadi"
        ];

        $result = $queryBuilder->table("users")->create($data);

        $this->assertIsInt($result);

        $this->assertGreaterThan(0, $result);
    }

    private function getConfig()
    {
        return Config::get("database", "pdo_testing");
    }
}
