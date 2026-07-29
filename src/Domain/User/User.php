<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Tasklist\Tasklist;
use App\Domain\UserSavedTasklist\UserSavedTasklist;
use App\Domain\UserSavedTaskProgress\UserSavedTaskProgress;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class User extends ActiveRecord
{
    public const MIN_PASSWORD_LENGTH = 8;
    public const MAX_PASSWORD_LENGTH = 96;
    public const MIN_USERNAME_LENGTH = 3;

    protected string $id;
    protected string $username;
    protected string $email;
    protected string $password_hash;
    protected UserStatus $status = UserStatus::ACTIVE;
    protected string $auth_key;
    protected int $created_at;
    protected int $updated_at;

    public function tableName(): string
    {
        return '{{%user}}';
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function setId(string $id): void
    {
        $this->set('id', $id);
    }

    public function getUsername(): ?string
    {
        return $this->username ?? null;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPasswordHash(): ?string
    {
        return $this->password_hash ?? null;
    }

    public function setPasswordHash(string $password_hash): void
    {
        $this->password_hash = $password_hash;
    }

    public function getStatus(): ?UserStatus
    {
        return $this->status ?? null;
    }

    public function setStatus(UserStatus $status): void
    {
        $this->status = $status;
    }

    public function getAuthKey(): ?string
    {
        return $this->auth_key ?? null;
    }

    public function setAuthKey(string $auth_key): void
    {
        $this->auth_key = $auth_key;
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
            'tasklists' => $this->getTasklistsQuery(),
            'userSavedTaskProgresses' => $this->getUserSavedTaskProgressesQuery(),
            'userSavedTasklists' => $this->getUserSavedTasklistsQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getTasklists(): array
    {
        return $this->relation('tasklists');
    }

    public function getTasklistsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Tasklist::class, ['user_id' => 'id'])->inverseOf('user');
    }

    public function getUserSavedTaskProgresses(): array
    {
        return $this->relation('userSavedTaskProgresses');
    }

    public function getUserSavedTaskProgressesQuery(): ActiveQueryInterface
    {
        return $this->hasMany(UserSavedTaskProgress::class, ['user_id' => 'id'])->inverseOf('user');
    }

    public function getUserSavedTasklists(): array
    {
        return $this->relation('userSavedTasklists');
    }

    public function getUserSavedTasklistsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(UserSavedTasklist::class, ['user_id' => 'id'])->inverseOf('user');
    }
}
