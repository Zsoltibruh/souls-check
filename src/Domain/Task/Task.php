<?php

declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\Target\Target;
use App\Domain\Tasklist\Tasklist;
use App\Domain\TaskTag\TaskTag;
use App\Domain\UserSavedTaskProgress\UserSavedTaskProgress;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class Task extends ActiveRecord
{
    protected string $id;
    protected string $tasklist_id;
    protected TaskType $type;
    protected string $target;
    protected ?string $required_weapon = null;
    protected ?string $required_spell = null;
    protected int $created_at;
    protected int $updated_at;

    public function tableName(): string
    {
        return '{{%task}}';
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function setId(string $id): void
    {
        $this->set('id', $id);
    }

    public function getTasklistId(): ?string
    {
        return $this->tasklist_id ?? null;
    }

    public function setTasklistId(string $tasklist_id): void
    {
        $this->set('tasklist_id', $tasklist_id);
    }

    public function getType(): ?TaskType
    {
        return $this->type ?? null;
    }

    public function setType(TaskType $type): void
    {
        $this->type = $type;
    }

    public function setTarget(string $target): void
    {
        $this->set('target', $target);
    }

    public function setRequiredWeapon(?string $required_weapon): void
    {
        $this->set('required_weapon', $required_weapon);
    }

    public function setRequiredSpell(?string $required_spell): void
    {
        $this->set('required_spell', $required_spell);
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at ?? null;
    }

    public function setCreatedAt(int $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?int
    {
        return $this->updated_at ?? null;
    }

    public function setUpdatedAt(int $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'tasklist' => $this->getTasklistQuery(),
            'target' => $this->getTargetQuery(),
            'requiredWeapon' => $this->getRequiredWeaponQuery(),
            'requiredSpell' => $this->getRequiredSpellQuery(),
            'taskTags' => $this->getTaskTagsQuery(),
            'userSavedTaskProgresses' => $this->getUserSavedTaskProgressesQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getTasklist(): ?Tasklist
    {
        return $this->relation('tasklist');
    }

    public function getTasklistQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Tasklist::class, ['id' => 'tasklist_id'])->inverseOf('tasks');
    }

    public function getTarget(): ?Target
    {
        return $this->relation('target');
    }

    public function getTargetQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Target::class, ['id' => 'target'])->inverseOf('tasks');
    }

    public function getRequiredWeapon(): ?Target
    {
        return $this->relation('requiredWeapon');
    }

    public function getRequiredWeaponQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Target::class, ['id' => 'required_weapon'])->inverseOf('tasks');
    }

    public function getRequiredSpell(): ?Target
    {
        return $this->relation('requiredSpell');
    }

    public function getRequiredSpellQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Target::class, ['id' => 'required_spell'])->inverseOf('tasks');
    }

    public function getTaskTags(): array
    {
        return $this->relation('taskTags');
    }

    public function getTaskTagsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(TaskTag::class, ['task_id' => 'id'])->inverseOf('task');
    }

    public function getUserSavedTaskProgresses(): array
    {
        return $this->relation('userSavedTaskProgresses');
    }

    public function getUserSavedTaskProgressesQuery(): ActiveQueryInterface
    {
        return $this->hasMany(UserSavedTaskProgress::class, ['task_id' => 'id'])->inverseOf('task');
    }
}
