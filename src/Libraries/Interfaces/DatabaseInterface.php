<?php

namespace Mark\Libraries\Interfaces;

/**
 * Interface DatabaseInterface
 * Defines methods for database operations.
 */
interface DatabaseInterface
{
    /**
     * Execute a select query with optional parameters and return the results.
     *
     * @param string $sql The SQL query
     * @param array $params The parameters to bind
     * @return array The fetched results
     */
    public function select(string $sql, array $params = []): array;

    /**
     * Execute a single row select query with optional parameters and return the result.
     *
     * @param string $sql The SQL query
     * @param array $params The parameters to bind
     * @return array|null The fetched result or null if no row found
     */
    public function selectOne(string $sql, array $params = []): ?array;

    /**
     * Execute a query with optional parameters and return the number of affected rows.
     *
     * @param string $sql The SQL query
     * @param array $params The parameters to bind
     * @return int The number of affected rows
     */
    public function exec(string $sql, array $params = []): int;

    /**
     * Get the ID of the last inserted row.
     *
     * @return string The last insert ID
     */
    public function lastInsertId(): mixed;

    /**
     * Execute a bulk insert operation with parameter binding.
     *
     * @param string $table The name of the table
     * @param array $data An array of associative arrays representing the rows to insert
     * @return int The number of affected rows
     */
    public function bulkInsert(string $table, array $data): int;

    /**
     * Execute an upsert operation (insert or update) with parameter binding.
     *
     * @param string $table The name of the table
     * @param array $data An associative array representing the row to upsert
     * @param array $uniqueKeys The unique keys to determine if the row exists
     * @return int The number of affected rows
     */
    public function upsert(string $table, array $data, array $uniqueKeys): int;

    /**
     * Update rows in the database table with parameter binding.
     *
     * @param string $table The name of the table
     * @param array $data An associative array representing the columns and values to update
     * @param string $where The WHERE clause to filter the rows to update
     * @param array $params The parameters to bind for the WHERE clause
     * @return int The number of affected rows
     */
    public function update(string $table, array $data, string $where, array $params = []): int;

    /**
     * Delete rows from the database table with parameter binding.
     *
     * @param string $table The name of the table
     * @param string $where The WHERE clause to filter the rows to delete
     * @param array $params The parameters to bind for the WHERE clause
     * @return int The number of affected rows
     */
    public function delete(string $table, string $where, array $params = []): int;

    /**
     * Get the last executed query.
     *
     * @return string The last executed query
     */
    public function lastQuery(): string;

    /**
     * Begin a database transaction.
     *
     * @return bool True on success, false on failure
     */
    public function beginTransaction(): bool;

    /**
     * Commit a database transaction.
     *
     * @return bool True on success, false on failure
     */
    public function commit(): bool;

    /**
     * Roll back a database transaction.
     *
     * @return bool True on success, false on failure
     */
    public function rollBack(): bool;
}
