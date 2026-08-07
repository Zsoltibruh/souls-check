<?php

declare(strict_types=1);

namespace App\UseCase\Profile\ViewProfile;

use App\Domain\User\User;
use App\Presentation\ResponseFactory\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use Yiisoft\Router\HydratorAttribute\RouteArgument;
use Yiisoft\User\CurrentUser;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    private const VIEW_PATH = __DIR__ . '/template';

    public function __construct(
        private CurrentUser $currentUser,
        private ResponseFactory $responseFactory
    ) {}

    public function __invoke(#[RouteArgument('id')] string $id): ResponseInterface
    {
        if (!$this->currentUser->isGuest() && $id === $this->currentUser->getIdentity()->getId()) {
            return $this->renderUser($this->currentUser->getIdentity()->user);
        }

        if (!Uuid::isValid($id)) {
            return $this->responseFactory->notFound(ResponseFactory::USER_NOT_FOUND);
        }

        $user = User::query()->where(['id' => $id])->one();
        if ($user === null) {
            return $this->responseFactory->notFound(ResponseFactory::USER_NOT_FOUND);
        }

        return $this->renderUser($user);
    }

    private function renderUser(User $user): ResponseInterface
    {
        return $this->responseFactory->render(self::VIEW_PATH, [
            'user' => $user
        ]);
    }
}
