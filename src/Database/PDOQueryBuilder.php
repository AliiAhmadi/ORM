<?php

namespace Orm\Database;

use Orm\Database\PDODatabaseConnection;

class PDOQueryBuilder
{
    protected string $table;
    protected \PDO|null $connection;

    public function __construct(PDODatabaseConnection $connection)
    {
        $this->connection = $connection->getConnection();
    }
    public function table(string $table): PDOQueryBuilder
    {
        $this->table = $table;

        return $this;
    }

    public function create(array $data): int
    {
        $placeHolder = [];
        foreach ($data as $column => $value) {
            $placeHolder[] = "?";
        }

        $fields = implode(",", array_keys($data));

        $placeHolderString = implode(",", $placeHolder);

        $query = "INSERT INTO {$this->table} ($fields) VALUES ($placeHolderString)";

        $this->connection->prepare($query)->execute(array_values($data));

        return (int) $this->connection->lastInsertId();
    }
}
