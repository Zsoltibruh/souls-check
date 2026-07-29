<?php

declare(strict_types=1);

namespace App\UseCase\Login;

use App\Domain\User\AuthKeyGenerator;
use App\Domain\User\User;
use App\Presentation\Identity\UserIdentity;
use App\Presentation\ResponseFactory\ResponseFactory;
use App\Shared\UrlGenerator;
use App\UseCase\Shared\HasForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Security\PasswordHasher;
use Yiisoft\User\CurrentUser;

final readonly class Action
{
    use HasForm;

    private const VIEW_PATH = __DIR__ . '/template';

    public function __construct(
        private ResponseFactory $responseFactory,
        private UrlGenerator $urlGenerator,
        private FormHydrator $formHydrator,
        private CurrentUser $currentUser,
        private AuthKeyGenerator $authKeyGenerator,
        private PasswordHasher $passwordHasher,
    ) {}
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $form = new Form();

        if (!$this->formHydrator->populateFromPostAndValidate($form, $request)) {
            return $this->renderForm($form, self::VIEW_PATH);
        }

        /** @var User|null $user */
        $user = User::query()->where(['username' => $form->username])->one();

        if (!$this->checkUser($form, $user)) {
            return $this->renderForm($form, self::VIEW_PATH);
        }

        if (!$this->loginUser($form, $user)) {
            return $this->renderForm($form, self::VIEW_PATH);
        }

        $response = $this->responseFactory->createResponse();

        return $this->responseFactory->redirect($this->urlGenerator->home(), $response);
    }

    private function checkUser(Form $form, ?User $user): bool
    {
        if ($user === null || !$this->passwordHasher->validate($form->password, $user->getPasswordHash())) {
            $form->addError($form::ERROR_MESSAGE);
            return false;
        }

        return true;
    }

    private function loginUser(Form $form, User $user): bool
    {
        $user->setAuthKey($this->authKeyGenerator->generate());
        $user->save();

        $identity = new UserIdentity($user, $this->authKeyGenerator);
        if (!$this->currentUser->login($identity)) {
            $form->addError('Login failed, try again later.');
            return false;
        }

        return true;
    }
}
