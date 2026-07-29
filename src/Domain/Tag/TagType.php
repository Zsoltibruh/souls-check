<?php

namespace App\Domain\Tag;

use App\Domain\Shared\Trait\HasLabel;

enum TagType: int
{
    use HasLabel;

    case TASK = 1;
    case TASKLIST = 2;
}
