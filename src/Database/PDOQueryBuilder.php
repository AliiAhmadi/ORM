<?php

namespace Orm\Database;

use Orm\Database\PDODatabaseConnection;

class PDOQueryBuilder
{
    protected string $table;
    protected \PDO|null $connection;
    protected array $conditions;
    protected array $conditionValues;

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

    public function where(string $column, string $value)
    {
        $this->conditions[] = "{$column}=?";

        $this->conditionValues[] = $value;

        return $this;
    }

    public function update(array $data)
    {
        $fields = [];

        foreach ($data as $column => $value) {
            $fields[] = "{$column}='{$value}'";
        }

        $fields = implode(",", $fields);

        $conditions = implode(" AND ", $this->conditions);

        $query = "UPDATE {$this->table} SET {$fields} WHERE {$conditions}";

        $query = $this->connection->prepare($query);

        $query->execute($this->conditionValues);

        return $query->rowCount();
    }

    public function truncateAllTables(): void
    {
        $query = $this->connection->prepare("SHOW TABLES");

        $query->execute();

        foreach ($query->fetchAll(\PDO::FETCH_COLUMN) as $table) {
            $this->connection->prepare("TRUNCATE TABLE `{$table}`")->execute();
        }
    }

    public function delete(): int
    {
        $conditions = implode(" AND ", $this->conditions);

        $query = "DELETE FROM `{$this->table}` WHERE {$conditions}";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($this->conditionValues);

        return $stmt->rowCount();
    }

    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function rollback(): void
    {
        $this->connection->rollBack();
    }
}
