<?php

namespace App\Domain\Tasklist;

use App\Domain\Shared\Trait\LabelTrait;

enum TasklistVisibilityEnum: int
{
    use LabelTrait;

    case PUBLIC = 1;
    case LINK = 2;
    case PRIVATE = 3;
}
