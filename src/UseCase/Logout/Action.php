<?php

namespace App\UseCase\Logout;

use App\Presentation\ResponseFactory\ResponseFactory;
use App\Shared\UrlGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\User\CurrentUser;

final readonly class Action
{
    public function __invoke(
        CurrentUser $currentUser,
        ResponseFactory $responseFactory,
        UrlGenerator $urlGenerator,
        LoggerInterface $logger,
    ): ResponseInterface {
        $logger->info("User '{$currentUser->getIdentity()->user->getUsername()}' logged out.", ['context' => __METHOD__]);
        $currentUser->logout();
        return $responseFactory->redirect($urlGenerator->home());
    }
}
