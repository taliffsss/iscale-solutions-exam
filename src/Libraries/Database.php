<?php
namespace Mark\Libraries;

use Mark\Libraries\Interfaces\DatabaseInterface;

/**
 * Class Database
 * 
 * Singleton class to manage database operations.
 * 
 * @package Mark\Libraries
 */
class Database implements DatabaseInterface
{
    /**
     * @var \PDO The PDO instance for database connection
     */
    private \PDO $pdo;

    /**
     * @var Database|null The singleton instance
     */
    private static ?Database $instance = null;

    /**
     * Private constructor to prevent direct object creation.
     */
    private function __construct()
    {
        // Retrieve database connection details from environment variables
        $dsn =$_ENV['DB_DSN'];
        $user =$_ENV['DB_UNAME'];
        $password =$_ENV['DB_PASS'];

        // Set up the PDO connection with best practices
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,  // Fetch associative arrays by default
            \PDO::ATTR_EMULATE_PREPARES => false,  // Use real prepared statements
            \PDO::ATTR_PERSISTENT => true,  // Use persistent connections
        ];

        try {
            $this->pdo = new \PDO($dsn, $user, $password, $options);
        } catch (\PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get the singleton instance of Database.
     *
     * @return Database The singleton instance
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Execute a select query with optional parameters and return the results.
     *
     * @param string $sql The SQL query
     * @param array $params The parameters to bind
     * @return array The fetched results
     */
    public function select(string $sql, array $params = []): array
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll();
    }

    /**
     * Execute a single row select query with optional parameters and return the result.
     *
     * @param string $sql The SQL query
     * @param array $params The parameters to bind
     * @return array|null The fetched result or null if no row found
     */
    public function selectOne(string $sql, array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        $result = $sth->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Execute a query with optional parameters and return the number of affected rows.
     *
     * @param string $sql The SQL query
     * @param array $params The parameters to bind
     * @return int The number of affected rows
     */
    public function exec(string $sql, array $params = []): int
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->rowCount();
    }

    /**
     * Get the ID of the last inserted row.
     *
     * @return string The last insert ID
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Execute a bulk insert operation with parameter binding.
     *
     * @param string $table The name of the table
     * @param array $data An array of associative arrays representing the rows to insert
     * @return int The number of affected rows
     */
    public function bulkInsert(string $table, array $data): int
    {
        $columns = array_keys($data[0]);
        $columnList = implode(',', $columns);
        $placeholders = rtrim(str_repeat('(' . rtrim(str_repeat('?,', count($columns)), ',') . '),', count($data)), ',');
        $sql = "INSERT INTO $table ($columnList) VALUES $placeholders";

        $stmt = $this->pdo->prepare($sql);

        $values = [];
        foreach ($data as $row) {
            foreach ($columns as $column) {
                $values[] = $row[$column];
            }
        }

        try {
            $this->beginTransaction();
            $stmt->execute($values);
            $rowCount = $stmt->rowCount();
            $this->commit();
            return $rowCount;
        } catch (\Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    /**
     * Execute an upsert operation (insert or update) with parameter binding.
     *
     * @param string $table The name of the table
     * @param array $data An associative array representing the row to upsert
     * @param array $uniqueKeys The unique keys to determine if the row exists
     * @return int The number of affected rows
     */
    public function upsert(string $table, array $data, array $uniqueKeys): int
    {
        $columns = array_keys($data);
        $columnList = implode(',', $columns);
        $placeholders = implode(',', array_fill(0, count($columns), '?'));

        $updateList = implode(', ', array_map(fn($col) => "$col = VALUES($col)", $columns));
        $sql = "INSERT INTO $table ($columnList) VALUES ($placeholders) ON DUPLICATE KEY UPDATE $updateList";

        $stmt = $this->pdo->prepare($sql);

        $values = array_values($data);

        try {
            $this->beginTransaction();
            $stmt->execute($values);
            $rowCount = $stmt->rowCount();
            $this->commit();
            return $rowCount;
        } catch (\Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    /**
     * Update rows in the database table with parameter binding.
     *
     * @param string $table The name of the table
     * @param array $data An associative array representing the columns and values to update
     * @param string $where The WHERE clause to filter the rows to update
     * @param array $params The parameters to bind for the WHERE clause
     * @return int The number of affected rows
     */
    public function update(string $table, array $data, string $where, array $params = []): int
    {
        $setList = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $sql = "UPDATE $table SET $setList WHERE $where";

        $stmt = $this->pdo->prepare($sql);

        $values = array_merge(array_values($data), $params);

        try {
            $this->beginTransaction();
            $stmt->execute($values);
            $rowCount = $stmt->rowCount();
            $this->commit();
            return $rowCount;
        } catch (\Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    /**
     * Delete rows from the database table with parameter binding.
     *
     * @param string $table The name of the table
     * @param string $where The WHERE clause to filter the rows to delete
     * @param array $params The parameters to bind for the WHERE clause
     * @return int The number of affected rows
     */
    public function delete(string $table, string $where, array $params = []): int
    {
        $sql = "DELETE FROM $table WHERE $where";

        $stmt = $this->pdo->prepare($sql);

        try {
            $this->beginTransaction();
            $stmt->execute($params);
            $rowCount = $stmt->rowCount();
            $this->commit();
            return $rowCount;
        } catch (\Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    /**
     * Get the last executed query.
     *
     * @return string The last executed query
     */
    public function lastQuery(): string
    {
        return trim(preg_replace('/\s\s+/', ' ', $this->pdo->queryString));
    }

    /**
     * Begin a database transaction.
     *
     * @return bool True on success, false on failure
     */
    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit a database transaction.
     *
     * @return bool True on success, false on failure
     */
    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    /**
     * Roll back a database transaction.
     *
     * @return bool True on success, false on failure
     */
    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }
}
