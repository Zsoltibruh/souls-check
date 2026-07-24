<?php

namespace App\Domain\User;

use App\Domain\Shared\Trait\LabelTrait;

enum UserStatusEnum: int
{
    use LabelTrait;

    case INACTIVE = 0;
    case ACTIVE = 1;
}
