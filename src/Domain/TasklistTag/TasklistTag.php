<?php

declare(strict_types=1);

namespace App\Domain\TasklistTag;

use App\Domain\Tag\Tag;
use App\Domain\Tasklist\Tasklist;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class TasklistTag extends ActiveRecord
{
    protected string $tag_id;
    protected string $tasklist_id;

    public function tableName(): string
    {
        return '{{%tasklist_tag}}';
    }

    public function getTagId(): ?string
    {
        return $this->tag_id ?? null;
    }

    public function setTagId(string $tag_id): void
    {
        $this->set('tag_id', $tag_id);
    }

    public function getTasklistId(): ?string
    {
        return $this->tasklist_id ?? null;
    }

    public function setTasklistId(string $tasklist_id): void
    {
        $this->set('tasklist_id', $tasklist_id);
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'tag' => $this->getTagQuery(),
            'tasklist' => $this->getTasklistQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getTag(): ?Tag
    {
        return $this->relation('tag');
    }

    public function getTagQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id'])->inverseOf('tasklistTags');
    }

    public function getTasklist(): ?Tasklist
    {
        return $this->relation('tasklist');
    }

    public function getTasklistQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Tasklist::class, ['id' => 'tasklist_id'])->inverseOf('tasklistTags');
    }
}
