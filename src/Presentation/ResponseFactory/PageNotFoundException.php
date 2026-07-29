<?php

namespace App\Presentation\ResponseFactory;

use Exception;
use Override;

class PageNotFoundException extends Exception
{
    public function __construct(
        public readonly string $title = "Page not found",
        public readonly string $description = '',
    ) {
        return parent::__construct($title . '/' . $description);
    }
}
