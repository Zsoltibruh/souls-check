<?php

declare(strict_types=1);

namespace App\Domain\Tag;

use App\Domain\TasklistTag\TasklistTag;
use App\Domain\TaskTag\TaskTag;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class Tag extends ActiveRecord
{
    protected string $id;
    protected TagTypeEnum $type;
    protected string $name;

    public function tableName(): string
    {
        return '{{%tag}}';
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function setId(string $id): void
    {
        $this->set('id', $id);
    }

    public function getType(): ?TagTypeEnum
    {
        return $this->type ?? null;
    }

    public function setType(TagTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'taskTags' => $this->getTaskTagsQuery(),
            'tasklistTags' => $this->getTasklistTagsQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getTaskTags(): array
    {
        return $this->relation('taskTags');
    }

    public function getTaskTagsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(TaskTag::class, ['tag_id' => 'id'])->inverseOf('tag');
    }

    public function getTasklistTags(): array
    {
        return $this->relation('tasklistTags');
    }

    public function getTasklistTagsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(TasklistTag::class, ['tag_id' => 'id'])->inverseOf('tag');
    }
}
