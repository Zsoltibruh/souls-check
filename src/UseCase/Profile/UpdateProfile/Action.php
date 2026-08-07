<?php

declare(strict_types=1);

namespace App\UseCase\Profile\UpdateProfile;

use App\Domain\User\User;
use App\Presentation\ResponseFactory\ResponseFactory;
use App\UseCase\Profile\UpdateProfile\ChangeEmail\Form as EmailForm;
use App\UseCase\Profile\UpdateProfile\ChangePassword\Form as PasswordForm;
use App\UseCase\Profile\UpdateProfile\ChangeUsername\Form as UsernameForm;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use Yiisoft\Router\HydratorAttribute\RouteArgument;
use Yiisoft\User\CurrentUser;

final readonly class Action
{
    public const URL_PATH = __DIR__ . '/template.php';

    public function __construct(
        private ResponseFactory $responseFactory,
        private CurrentUser $currentUser,
    ) {}

    public function __invoke(#[RouteArgument('id')] string $id): ResponseInterface
    {
        if (!Uuid::isValid($id)) {
            return $this->responseFactory->notFound(ResponseFactory::USER_NOT_FOUND);
        }

        /** @var User $user */
        $user = $this->currentUser->getIdentity()->user;

        $usernameForm = new UsernameForm($user);
        $emailForm = new EmailForm($user);
        $passwordForm = new PasswordForm();

        return $this->responseFactory->render(self::URL_PATH, [
            'usernameForm' => $usernameForm,
            'emailForm' => $emailForm,
            'passwordForm' => $passwordForm,
        ]);
    }
}
