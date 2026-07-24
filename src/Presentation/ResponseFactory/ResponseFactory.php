<?php

namespace App\Presentation\ResponseFactory;

use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final readonly class ResponseFactory implements ResponseFactoryInterface
{
    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        throw new \Exception('Not implemented');
    }
}
