<?php

namespace Orm\Database;

use Orm\Exceptions\DatabaseConnectionException;
use Orm\Contracts\DatabaseConnectionInterface;

class PDODatabaseConnection implements DatabaseConnectionInterface
{
    protected \PDO|null $connection;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
    public function connect(): PDODatabaseConnection
    {
        $dsn = $this->generateDsn();

        try {
            $this->connection = new \PDO($dsn, $this->config["db_user"], $this->config["db_password"]);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            throw new DatabaseConnectionException($e->getMessage());
        }

        return $this;
    }

    public function getConnection(): \PDO|null
    {
        return $this->connection;
    }

    private function generateDsn(): string
    {
        $dsn = $this->config["driver"] .
            ":host=" . $this->config["host"] .
            ";dbname=" . $this->config["database"] .
            ";charset=utf8";

        return $dsn;
    }
}
