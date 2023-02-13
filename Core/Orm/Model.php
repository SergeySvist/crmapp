<?php

namespace Core\Orm;

use Core\DB;
use PDOStatement;

class Model implements \JsonSerializable
{
    /**
     * Table name that associated with the current model
     * @var string
     */
    protected string $table;
    protected string $identity = 'id';
    protected array $fields = [];
    protected array $fillable = [];
    protected array $data = [];

    // ===============================================
    public function __get(string $property): mixed
    {
        if (array_key_exists($property, $this->data))
            return $this->data[$property];

        return null;
    }

    public function __set(string $property, mixed $value): void
    {
        $this->data[$property] = $value;
    }

    public function jsonSerialize(): array
    {
        return $this->data;     // TODO: add hidden array to Model ==> filtering
    }

    public function setState(array $data): Model
    {
        foreach ($this->fillable as $property) {
            if (array_key_exists($property, $data)) {
                $this->data[$property] = $data[$property];
            }
        }

        return $this;
    }

    public function save()
    {
        return SqlCore::addRow($this->table, $this->data);
    }

    public function update()
    {
        return SqlCore::updateRow($this->table, $this->identity, $this->data[$this->identity], $this->data);
    }

    public static function delete($id): bool
    {
        $modelClass = get_called_class();
        $model = new $modelClass();

        $rowCount = SqlCore::deleteRow($model->table, $id)->rowCount();

        return $rowCount > 0;
    }

    public static function findOne(array $conditions)
    {
        $modelClass = get_called_class();
        $model = new $modelClass();

        $model->data = SqlCore::getBy($model->table, $conditions)->fetch() ?: [];

        if ($model->data)
            return $model;

        // TODO: add exception
        return null;
    }

    public static function checkExists(array $conditions){
        $modelClass = get_called_class();
        $model = new $modelClass();

        return SqlCore::existsRow($model->table, $conditions)->fetch();
    }

    public static function create(array $data): Model
    {
        $modelClass = get_called_class();
        $model = new $modelClass();

        foreach ($model->fillable as $property) {
            if (array_key_exists($property, $data)) {
                $model->data[$property] = $data[$property];
            } else {
                $model->data[$property] = null;
            }
        }

        return $model;
    }

    public static function all(string $sortVal = null, bool $sortDir = null)
    {
        $modelClass = get_called_class();
        $model = new $modelClass();

        $dataArray = SqlCore::getBy($model->table, [], $sortVal, $sortDir)->fetchAll();

        $resArray =array_map(function($data) use ($modelClass) {
            $m = new $modelClass();

            foreach ($m->fields as $property) {
                if (array_key_exists($property, $data))
                    $m->data[$property] = $data[$property];
                else
                    $m->data[$property] = null;
            }

            return $m;

        }, $dataArray);
        return $resArray;
    }







}
