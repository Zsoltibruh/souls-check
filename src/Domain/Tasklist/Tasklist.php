<?php

declare(strict_types=1);

namespace App\Domain\Tasklist;

use App\Domain\Character\Character;
use App\Domain\Game\Game;
use App\Domain\Stat\Stat;
use App\Domain\Target\Target;
use App\Domain\Task\Task;
use App\Domain\TasklistTag\TasklistTag;
use App\Domain\User\User;
use App\Domain\UserSavedTasklist\UserSavedTasklist;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class Tasklist extends ActiveRecord
{
    protected string $id;
    protected string $title;
    protected string $slug;
    protected string $user_id;
    protected string $game_id;
    protected TasklistDifficulty $difficulty = TasklistDifficulty::EASY;
    protected TasklistVisibility $visibility = TasklistVisibility::PUBLIC;
    protected bool $is_ordered = false;
    protected ?string $character_id = null;
    protected ?string $target_id = null;
    protected ?string $stat_id = null;
    protected int $created_at;
    protected int $updated_at;

    public function tableName(): string
    {
        return '{{%tasklist}}';
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function setId(string $id): void
    {
        $this->set('id', $id);
    }

    public function getTitle(): ?string
    {
        return $this->title ?? null;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSlug(): ?string
    {
        return $this->slug ?? null;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getUserId(): ?string
    {
        return $this->user_id ?? null;
    }

    public function setUserId(string $user_id): void
    {
        $this->set('user_id', $user_id);
    }

    public function getGameId(): ?string
    {
        return $this->game_id ?? null;
    }

    public function setGameId(string $game_id): void
    {
        $this->set('game_id', $game_id);
    }

    public function getDifficulty(): TasklistDifficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(TasklistDifficulty $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getVisibility(): TasklistVisibility
    {
        return $this->visibility;
    }

    public function setVisibility(TasklistVisibility $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function getIsOrdered(): bool
    {
        return $this->is_ordered;
    }

    public function setIsOrdered(bool $is_ordered): void
    {
        $this->is_ordered = $is_ordered;
    }

    public function getCharacterId(): ?string
    {
        return $this->character_id;
    }

    public function setCharacterId(?string $character_id): void
    {
        $this->set('character_id', $character_id);
    }

    public function getTargetId(): ?string
    {
        return $this->target_id;
    }

    public function setTargetId(?string $target_id): void
    {
        $this->set('target_id', $target_id);
    }

    public function getStatId(): ?string
    {
        return $this->stat_id;
    }

    public function setStatId(?string $stat_id): void
    {
        $this->set('stat_id', $stat_id);
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
            'user' => $this->getUserQuery(),
            'game' => $this->getGameQuery(),
            'character' => $this->getCharacterQuery(),
            'target' => $this->getTargetQuery(),
            'stat' => $this->getStatQuery(),
            'tasks' => $this->getTasksQuery(),
            'tasklistTags' => $this->getTasklistTagsQuery(),
            'userSavedTasklists' => $this->getUserSavedTasklistsQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getUser(): ?User
    {
        return $this->relation('user');
    }

    public function getUserQuery(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('tasklists');
    }

    public function getGame(): ?Game
    {
        return $this->relation('game');
    }

    public function getGameQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Game::class, ['id' => 'game_id'])->inverseOf('tasklists');
    }

    public function getCharacter(): ?Character
    {
        return $this->relation('character');
    }

    public function getCharacterQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Character::class, ['id' => 'character_id'])->inverseOf('tasklists');
    }

    public function getTarget(): ?Target
    {
        return $this->relation('target');
    }

    public function getTargetQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Target::class, ['id' => 'target_id'])->inverseOf('tasklists');
    }

    public function getStat(): ?Stat
    {
        return $this->relation('stat');
    }

    public function getStatQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Stat::class, ['id' => 'stat_id'])->inverseOf('tasklists');
    }

    public function getTasks(): array
    {
        return $this->relation('tasks');
    }

    public function getTasksQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Task::class, ['tasklist_id' => 'id'])->inverseOf('tasklist');
    }

    public function getTasklistTags(): array
    {
        return $this->relation('tasklistTags');
    }

    public function getTasklistTagsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(TasklistTag::class, ['tasklist_id' => 'id'])->inverseOf('tasklist');
    }

    public function getUserSavedTasklists(): array
    {
        return $this->relation('userSavedTasklists');
    }

    public function getUserSavedTasklistsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(UserSavedTasklist::class, ['tasklist_id' => 'id'])->inverseOf('tasklist');
    }
}
