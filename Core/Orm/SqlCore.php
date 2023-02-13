<?php

namespace Core\Orm;

use Core\DB;
use PDOStatement;

class SqlCore
{

    public static function getBy(string $table, array $args = [], string $sortVal = null, bool $sortDir = null): PDOStatement
    {
        $sql = "SELECT * FROM $table";

        if ($args) {
            $conditions = array_map(fn($k) => "$k=:$k", array_keys($args));

            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        if($sortVal){
            $dir = 'ASC';
            if($sortDir)
                $dir = 'DESC';
            $sql .= " ORDER BY $sortVal $dir";
        }
        $sql .= ';';
        return DB::run($sql, $args);
    }

    public static function addRow(string $table, array $fields)
    {
        $fieldNames = array_keys($fields);
        $sqlNames = implode(', ', $fieldNames);

        $placeholders = array_map(fn($k) => ':' . $k, $fieldNames);
        $sqlValues = implode(', ', $placeholders);

        $sql = "INSERT INTO $table ($sqlNames) VALUES ($sqlValues)";

        DB::run($sql, $fields);
        return DB::getPdo()->lastInsertId();

    }

    public static function updateRow(string $table, string $identity, mixed $id, array $fields)
    {
        unset($fields[$identity]);

        $setters = array_map(fn($k) => "$k = :$k", array_keys($fields));

        $sql = "UPDATE $table SET "
            . implode(', ', $setters)
            . " WHERE $identity = $id;";

        DB::run($sql, $fields);
        return DB::getPdo()->lastInsertId();

    }

    public static function deleteRow(string $table, mixed $id): PDOStatement
    {
        $sql = "DELETE FROM $table WHERE id = :id";

        return DB::run($sql, ['id' => $id]);
    }

    public static function existsRow(string $table, array $args){

        $conditions = array_map(fn($k) => "$k=:$k", array_keys($args));
        $sql = "SELECT EXISTS(SELECT * FROM $table WHERE " . implode(' AND ', $conditions) . ");";
        return DB::run($sql, $args);
    }
}