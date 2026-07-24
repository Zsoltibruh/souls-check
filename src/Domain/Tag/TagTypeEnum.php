<?php

namespace App\Domain\Tag;

use App\Domain\Shared\Trait\LabelTrait;

enum TagTypeEnum: int
{
    use LabelTrait;

    case TASK = 1;
    case TASKLIST = 2;
}
