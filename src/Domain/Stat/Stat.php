<?php

declare(strict_types=1);

namespace App\Domain\Stat;

use App\Domain\Game\Game;
use App\Domain\Tasklist\Tasklist;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class Stat extends ActiveRecord
{
    protected string $id;
    protected string $game_id;
    protected string $name;

    public function tableName(): string
    {
        return '{{%stat}}';
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

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'game' => $this->getGameQuery(),
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
        return $this->hasOne(Game::class, ['id' => 'game_id'])->inverseOf('stats');
    }

    public function getTasklists(): array
    {
        return $this->relation('tasklists');
    }

    public function getTasklistsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Tasklist::class, ['stat_id' => 'id'])->inverseOf('stat');
    }
}
