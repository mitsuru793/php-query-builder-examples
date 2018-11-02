<?php
declare(strict_types=1);

namespace Example\Hydrahon;

final class Post extends Model
{
    protected const TABLE = 'posts';

    /** @var int */
    public $authorId;

    /** @var string */
    public $title;

    /** @var string */
    public $content;

    /** @var PostStatus */
    public $status;

    public function author(): User
    {
        return User::findById($this->authorId);
    }

    public function toArray(): array
    {
        return parent::toArray() + [
                'author_id' => (int)$this->authorId,
                'title' => $this->title,
                'content' => $this->content,
                'status' => $this->status->value(),
            ];
    }

    public function fill(array $fields): self
    {
        parent::fill($fields);
        $this->authorId = (int)$fields['author_id'];
        $this->title = $fields['title'];
        $this->content = $fields['content'];
        $this->status = new PostStatus((int)$fields['status']);
        return $this;
    }
}

