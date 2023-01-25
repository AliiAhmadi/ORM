<?php

namespace Tests\Unit;

use Orm\Database\PDODatabaseConnection;
use Orm\Helpers\Config;
use PHPUnit\Framework\TestCase;
use Orm\Database\PDOQueryBuilder;

class PDOQueryBuilderTest extends TestCase
{
    private $queryBuilder;

    public function setUp(): void
    {
        $pdoConnection = new PDODatabaseConnection($this->getConfig());

        $this->queryBuilder = new PDOQueryBuilder($pdoConnection->connect());

        $this->queryBuilder->beginTransaction();

        parent::setUp();
    }
    public function testItCanCreateDataAndInsertThem()
    {
        $data = [
            "full_name" => "Ali Ahmadi",
            "email" => "aliahmadi@gmail.com",
            "github_profile" => "https://github/aliiahmadi"
        ];

        $result = $this->queryBuilder->table("users")->create($data);

        $this->assertIsInt($result);

        $this->assertGreaterThan(0, $result);
    }


    private function getConfig()
    {
        return Config::get("database", "pdo_testing");
    }

    public function testItCanUpdateDataInDatabase()
    {
        $result = $this->queryBuilder
            ->table("users")
            ->where("id", 1)
            ->update(["email" => "test@gmail.com", "full_name" => "ali hastam :)"]);

        $this->assertGreaterThanOrEqual(0, $result);
    }

    public function tearDown(): void
    {
        // $this->queryBuilder->truncateAllTables();

        $this->queryBuilder->rollBack();

        parent::tearDown();
    }

    public function testItCanDeleteFromTable()
    {
        $data = [
            "full_name" => "reza",
            "email" => "reza@gmail.com",
            "github_profile" => "https://github/rerereza"
        ];

        $this->queryBuilder->table("users")->create($data);

        $result = $this->queryBuilder
            ->table("users")
            ->where("email", "reza@gmail.com")
            ->delete();

        $this->assertEquals(1, $result);
    }
}
