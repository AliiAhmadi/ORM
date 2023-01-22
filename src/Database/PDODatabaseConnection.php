<?php

namespace Orm\Database;

use Orm\Exceptions\DatabaseConnectionException;
use Orm\Contracts\DatabaseConnectionInterface;
use Orm\Exceptions\IncorrectConfigInfoException;

class PDODatabaseConnection implements DatabaseConnectionInterface
{
    public const REQUIRED_CONFIG_KEYS = [
        "driver",
        "database",
        "host",
        "db_user",
        "db_password"
    ];
    protected \PDO|null $connection;
    protected array $config;

    public function __construct(array $config)
    {
        if (!self::IsValidConfig($config)) {
            throw new IncorrectConfigInfoException();
        }
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

    private static function IsValidConfig(array $config): bool
    {
        $intersectResult = array_intersect(self::REQUIRED_CONFIG_KEYS, array_keys($config));

        if (count($intersectResult) === count(self::REQUIRED_CONFIG_KEYS)) {
            return true;
        }
        return false;
    }
}
