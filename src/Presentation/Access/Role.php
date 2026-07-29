<?php

declare(strict_types=1);

namespace App\Presentation\Access;

use App\Domain\Shared\Trait\HasLabel;

enum Role: string
{
    use HasLabel;

    case ADMIN = 'admin';
    case USER = 'user';
}
