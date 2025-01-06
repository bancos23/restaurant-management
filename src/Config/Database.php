<?php

namespace App\Config;

use PDO;
use PDOException;

/**
 * Database class to handle database connections using Singleton Pattern.
 */
class Database {
    /**
     * @var PDO The database connection instance.
     */
    private static $connection = null;

    /**
     * @var string The DSN (Data Source Name) for the database connection.
     */
    private static $dsn;

    /**
     * @var string The database username.
     */
    private static $username;

    /**
     * @var string The database password.
     */
    private static $password;

    /**
     * Private constructor to prevent instantiating the Database class.
     */
    private function __construct() {}

    /**
     * Initialize the database connection using the Singleton pattern.
     */
    private static function initializeConnection(): void {
        if (self::$connection === null) {
            self::$dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=' . $_ENV['DB_CHARSET'];
            self::$username = $_ENV['DB_USER'];
            self::$password = $_ENV['DB_PASS'];

            try {
                self::$connection = new PDO(self::$dsn, self::$username, self::$password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                file_put_contents('error_log', $e->getMessage() . PHP_EOL, FILE_APPEND);
                die('[MySQL] Connection failed!');
            }
        }
    }

    /**
     * Get the database connection instance.
     *
     * @return PDO The database connection instance.
     */
    public static function getInstance(): PDO {
        self::initializeConnection();
        return self::$connection;
    }

    /**
     * Executes a SQL query and returns the result.
     *
     * @param string $query The SQL query to execute.
     * @param array $params The parameters for the query.
     * @return array The result set as an associative array.
     */
    public static function executeQuery(string $query, array $params = []): array {
        $stmt = self::getInstance()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Executes a SQL query and returns a single value (e.g., COUNT, SUM, etc.).
     *
     * @param string $query The SQL query to execute.
     * @param array $params The parameters for the query.
     * @return mixed The single result value.
     */
    public static function executeScalar(string $query, array $params = []) {
        $stmt = self::getInstance()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Get data from a table based on the ID.
     *
     * @param string $table The table name.
     * @param string $data The column name.
     * @param int $id The ID of the row.
     * @return mixed The data value.
     */
    public static function getData($table, $data, $id) {
        $stmt = self::getInstance()->prepare('SELECT `'.$data.'` FROM `'.$table.'` WHERE `id` = :id');
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
}
