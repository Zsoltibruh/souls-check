<?php

declare(strict_types=1);

namespace App\Presentation\Access;

use App\Presentation\ResponseFactory\ResponseFactory;
use App\Shared\UrlGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\User\CurrentUser;

final readonly class GuestOnly implements MiddlewareInterface
{
    public function __construct(
        private CurrentUser $currentUser,
        private ResponseFactory $responseFactory,
        private UrlGenerator $urlGenerator,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->currentUser->isGuest()) {
            return $this->responseFactory->redirect($this->urlGenerator->home());
        }

        return $handler->handle($request);
    }
}
