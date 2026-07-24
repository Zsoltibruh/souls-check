<?php

declare(strict_types=1);

namespace App\Domain\TaskTag;

use App\Domain\Tag\Tag;
use App\Domain\Task\Task;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class TaskTag extends ActiveRecord
{
    protected string $tag_id;
    protected string $task_id;

    public function tableName(): string
    {
        return '{{%task_tag}}';
    }

    public function getTagId(): ?string
    {
        return $this->tag_id ?? null;
    }

    public function setTagId(string $tag_id): void
    {
        $this->set('tag_id', $tag_id);
    }

    public function getTaskId(): ?string
    {
        return $this->task_id ?? null;
    }

    public function setTaskId(string $task_id): void
    {
        $this->set('task_id', $task_id);
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'tag' => $this->getTagQuery(),
            'task' => $this->getTaskQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getTag(): ?Tag
    {
        return $this->relation('tag');
    }

    public function getTagQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id'])->inverseOf('taskTags');
    }

    public function getTask(): ?Task
    {
        return $this->relation('task');
    }

    public function getTaskQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Task::class, ['id' => 'task_id'])->inverseOf('taskTags');
    }
}
