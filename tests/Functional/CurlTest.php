<?php

namespace Tests\Functional;

use Orm\Database\PDODatabaseConnection;
use Orm\Database\PDOQueryBuilder;
use Orm\Helpers\HttpClient;
use PHPUnit\Framework\TestCase;
use Orm\Helpers\Config;

class CrudTest extends TestCase
{
    private $httpClient;
    protected $queryBuilder;

    public function setUp(): void
    {
        $pdoConnection = new PDODatabaseConnection(Config::get("database", "pdo_testing"));

        $this->queryBuilder = new PDOQueryBuilder($pdoConnection);

        $this->httpClient = new HttpClient();

        parent::setUp();
    }

    public function tearDown(): void
    {
        $this->httpClient = null;

        parent::tearDown();
    }
}
