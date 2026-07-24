<?php

declare(strict_types=1);

namespace App\Domain\UserSavedTaskProgress;

use App\Domain\Task\Task;
use App\Domain\User\User;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class UserSavedTaskProgress extends ActiveRecord
{
    protected string $user_id;
    protected string $task_id;
    protected bool $is_completed = false;
    protected ?int $completed_at = null;

    public function tableName(): string
    {
        return '{{%user_saved_task_progress}}';
    }

    public function getUserId(): ?string
    {
        return $this->user_id ?? null;
    }

    public function setUserId(string $user_id): void
    {
        $this->set('user_id', $user_id);
    }

    public function getTaskId(): ?string
    {
        return $this->task_id ?? null;
    }

    public function setTaskId(string $task_id): void
    {
        $this->set('task_id', $task_id);
    }

    public function getIsCompleted(): bool
    {
        return $this->is_completed;
    }

    public function setIsCompleted(bool $is_completed): void
    {
        $this->is_completed = $is_completed;
    }

    public function getCompletedAt(): ?int
    {
        return $this->completed_at;
    }

    public function setCompletedAt(?int $completed_at): void
    {
        $this->completed_at = $completed_at;
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'user' => $this->getUserQuery(),
            'task' => $this->getTaskQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getUser(): ?User
    {
        return $this->relation('user');
    }

    public function getUserQuery(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('userSavedTaskProgresses');
    }

    public function getTask(): ?Task
    {
        return $this->relation('task');
    }

    public function getTaskQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Task::class, ['id' => 'task_id'])->inverseOf('userSavedTaskProgresses');
    }
}
