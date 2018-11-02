<?php
declare(strict_types=1);

namespace Example\Hydrahon;

final class PostStatus
{
    public const PUBLIC = 1;
    public const DRAFT = 0;
    public const DELETED = -1;

    /** @var int */
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}