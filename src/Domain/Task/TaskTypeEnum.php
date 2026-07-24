<?php

namespace App\Domain\Task;

use App\Domain\Shared\Trait\LabelTrait;

enum TaskTypeEnum: int
{
    use LabelTrait;

    case DEFEAT = 1;
    case COLLECT = 2;
    //TODO: more types
}
