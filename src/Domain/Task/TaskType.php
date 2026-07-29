<?php

namespace App\Domain\Task;

use App\Domain\Shared\Trait\HasLabel;

enum TaskType: int
{
    use HasLabel;

    case DEFEAT = 1;
    case COLLECT = 2;
    //TODO: more types
}
