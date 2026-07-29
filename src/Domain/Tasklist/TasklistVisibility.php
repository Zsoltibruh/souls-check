<?php

namespace App\Domain\Tasklist;

use App\Domain\Shared\Trait\HasLabel;

enum TasklistVisibility: int
{
    use HasLabel;

    case PUBLIC = 1;
    case LINK = 2;
    case PRIVATE = 3;
}
