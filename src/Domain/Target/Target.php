<?php

declare(strict_types=1);

namespace App\Domain\Target;

use App\Domain\Game\Game;
use App\Domain\Task\Task;
use App\Domain\Tasklist\Tasklist;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class Target extends ActiveRecord
{
    protected string $id;
    protected string $game_id;
    protected string $name;
    protected int $type;
    protected string $category;

    public function tableName(): string
    {
        return '{{%target}}';
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function setId(string $id): void
    {
        $this->set('id', $id);
    }

    public function getGameId(): ?string
    {
        return $this->game_id ?? null;
    }

    public function setGameId(string $game_id): void
    {
        $this->set('game_id', $game_id);
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): ?int
    {
        return $this->type ?? null;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getCategory(): ?string
    {
        return $this->category ?? null;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'game' => $this->getGameQuery(),
            'tasks' => $this->getTasksQuery(),
            'tasklists' => $this->getTasklistsQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getGame(): ?Game
    {
        return $this->relation('game');
    }

    public function getGameQuery(): ActiveQueryInterface
    {
        return $this->hasOne(Game::class, ['id' => 'game_id'])->inverseOf('targets');
    }

    public function getTasks(): array
    {
        return $this->relation('tasks');
    }

    public function getTasksQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Task::class, ['target' => 'id'])->inverseOf('target');
    }

    public function getTasklists(): array
    {
        return $this->relation('tasklists');
    }

    public function getTasklistsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Tasklist::class, ['target_id' => 'id'])->inverseOf('target');
    }
}
