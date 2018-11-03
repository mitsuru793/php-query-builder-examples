<?php
declare(strict_types=1);

namespace Example\Hydrahon;

final class User extends Model
{
    protected const TABLE = 'users';

    /** @var string */
    public $name;

    public static function findByName(string $name): array
    {
        $rows = self::select()->where('name', $name)->get();
        return self::build($rows);
    }

    public function toArray(): array
    {
        $a = parent::toArray() + [
                'name' => $this->name,
            ];
        return $a;
    }

    public function fill(array $fields): self
    {
        parent::fill($fields);
        $this->name = $fields['name'];
        return $this;
    }
}