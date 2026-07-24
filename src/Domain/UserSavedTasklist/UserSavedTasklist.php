<?php

declare(strict_types=1);

namespace App\Domain\UserSavedTasklist;

use App\Domain\Tasklist\Tasklist;
use App\Domain\User\User;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class UserSavedTasklist extends ActiveRecord
{
    protected string $user_id;
    protected string $tasklist_id;
    protected bool $is_completed = false;
    protected int $created_at;

    public function tableName(): string
    {
        return '{{%user_saved_tasklist}}';
    }

    public function getUserId(): ?string
    {
        return $this->user_id ?? null;
    }

    public function setUserId(string $user_id): void
    {
        $this->set('user_id', $user_id);
    }

    public function getTasklistId(): ?string
    {
        return $this->tasklist_id ?? null;
    }

    public function setTasklistId(string $tasklist_id): void
    {
        $this->set('tasklist_id', $tasklist_id);
    }

    public function getIsCompleted(): bool
    {
        return $this->is_completed;
    }

    public function setIsCompleted(bool $is_completed): void
    {
        $this->is_completed = $is_completed;
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at ?? null;
    }

    public function setCreatedAt(int $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'user' => $this->getUserQuery(),
            'tasklist' => $this->getTasklistQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getUser(): ?User
    {
        return $this->relation('user');
    }

    public function getUserQuery(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('userSavedTasklists');
    }

    public function getTasklist(): ?Tasklist
    {
        return $this->relation('tasklist');
    }

    public function getTasklistQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Tasklist::class, ['id' => 'tasklist_id'])->inverseOf('userSavedTasklists');
    }
}
