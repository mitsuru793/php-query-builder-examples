<?php
declare(strict_types=1);

namespace Example\Hydrahon;

use ClanCats\Hydrahon\Builder;
use ClanCats\Hydrahon\Query\Sql\Select;
use ClanCats\Hydrahon\Query\Sql\Table;
use PDO;

abstract class Model
{
    protected const TABLE = null;

    /** @var PDO */
    public static $pdo;

    /** @var Builder */
    protected static $builder;

    /** @var int */
    public $id;

    /**
     * @return static
     */
    public static function findById(int $id)
    {
        $row = self::select()->where('id', $id)->get()[0];
        $model = new static;
        return $model->fill($row);
    }

    /**
     * @return static[]
     */
    public static function findByIds(array $ids)
    {
        $rows = self::select()->where('id', 'in', $ids)->get();
        $models = [];
        foreach ($rows as $row) {
            $model = new static();
            $model->fill($row);
            $models[] = $model;
        }
        return $models;
    }

    public function toArray(): array
    {
        if ($this->id > 0) {
            return [
                'id' => (int)$this->id,
            ];
        }

        return [];
    }

    /**
     * @return static
     */
    public function fill(array $fields)
    {
        $this->id = $fields['id'];
        return $this;
    }

    /**
     * @return static
     */
    public function save()
    {
        return self::query()->insert($this->toArray())->execute();
    }

    protected static function select($fields = null): Select
    {
        return self::query()->select($fields);
    }

    private static function query(): Table
    {
        if (static::$builder) {
            return static::$builder->table(static::TABLE);
        }

        static::$builder = new Builder('mysql', function ($query, $queryString, $queryParameters) {
            $statement = self::$pdo->prepare($queryString);
            $statement->execute($queryParameters);

            // when the query is fetchable return all results and let hydrahon do the rest
            if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface) {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
        });
        assert(is_string(static::TABLE));
        $table = static::$builder->table(static::TABLE);
        return $table;
    }
}
