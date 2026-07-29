<?php

namespace App\Domain\User;

use App\Domain\Shared\Trait\HasLabel;

enum UserStatus: int
{
    use HasLabel;

    case INACTIVE = 0;
    case ACTIVE = 1;
}
