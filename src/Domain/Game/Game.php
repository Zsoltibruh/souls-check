<?php

declare(strict_types=1);

namespace App\Domain\Game;

use App\Domain\Character\Character;
use App\Domain\Stat\Stat;
use App\Domain\Target\Target;
use App\Domain\Tasklist\Tasklist;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveQueryInterface;

final class Game extends ActiveRecord
{
    protected string $id;
    protected string $title;
    protected string $slug;
    protected string $cover_image;

    public function tableName(): string
    {
        return '{{%game}}';
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

    public function getCoverImage(): ?string
    {
        return $this->cover_image ?? null;
    }

    public function setCoverImage(string $cover_image): void
    {
        $this->cover_image = $cover_image;
    }

    public function relationQuery(string $name): ActiveQueryInterface
    {
        return match ($name) {
            'characters' => $this->getCharactersQuery(),
            'stats' => $this->getStatsQuery(),
            'targets' => $this->getTargetsQuery(),
            'tasklists' => $this->getTasklistsQuery(),
            default => parent::relationQuery($name),
        };
    }

    public function getCharacters(): array
    {
        return $this->relation('characters');
    }

    public function getCharactersQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Character::class, ['game_id' => 'id'])->inverseOf('game');
    }

    public function getStats(): array
    {
        return $this->relation('stats');
    }

    public function getStatsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Stat::class, ['game_id' => 'id'])->inverseOf('game');
    }

    public function getTargets(): array
    {
        return $this->relation('targets');
    }

    public function getTargetsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Target::class, ['game_id' => 'id'])->inverseOf('game');
    }

    public function getTasklists(): array
    {
        return $this->relation('tasklists');
    }

    public function getTasklistsQuery(): ActiveQueryInterface
    {
        return $this->hasMany(Tasklist::class, ['game_id' => 'id'])->inverseOf('game');
    }
}
