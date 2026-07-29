<?php

namespace App\Domain\Tasklist;

use App\Domain\Shared\Trait\HasLabel;

enum TasklistDifficulty: int
{
    use HasLabel;

    case EASY = 1;
    case NORMAL = 2;
    case HARD = 3;
    case SPEEDRUNNER = 4;
    case IMPOSSIBLE = 5;
}
