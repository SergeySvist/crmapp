<?php

namespace Core;

use PDO;
use PDOStatement;

class DB
{
    private static PDO $pdo;

    public static function getPdo(): PDO
    {
        if (! isset(self::$pdo)) {
            $connString = "mysql:host=" . DB_HOST . ";dbname=" .DB_NAME . ";charset=" . DB_CHARSET;

            // TODO: move to config
            $options = [
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES      => false,
            ];

            self::$pdo = new PDO($connString, DB_USERNAME, DB_PASS, $options);
        }

        return self::$pdo;
    }

    public static function run(string $sql, array $args = []): PDOStatement
    {
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute($args);

        return $stmt;
    }
}
