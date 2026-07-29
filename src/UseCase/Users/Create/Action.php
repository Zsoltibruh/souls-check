<?php

declare(strict_types=1);

namespace App\UseCase\Users\Create;

use App\Domain\User\AuthKeyGenerator;
use App\Domain\User\User;
use App\Presentation\Access\Role;
use App\Presentation\ResponseFactory\ResponseFactory;
use App\Shared\UrlGenerator;
use App\UseCase\Shared\HasForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Rbac\ManagerInterface;
use Yiisoft\Security\PasswordHasher;

final readonly class Action
{
    use HasForm;

    private const VIEW_PATH = __DIR__ . '/template';

    public function __construct(
        private UrlGenerator $urlGenerator,
        private FormHydrator $formHydrator,
        private ResponseFactory $responseFactory,
        private PasswordHasher $passwordHasher,
        private AuthKeyGenerator $authKeyGenerator,
        private ManagerInterface $rbacManager,
        private ConnectionInterface $db,
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $form = new Form();

        if (!$this->formHydrator->populateFromPostAndValidate($form, $request)) {
            return $this->renderForm($form, self::VIEW_PATH);
        }

        if (!$this->validateInputs($form)) {
            return $this->renderForm($form, self::VIEW_PATH);
        }

        $this->createUser($form);

        return $this->responseFactory->redirect($this->urlGenerator->generate('home'));
    }

    private function validateInputs(Form $form): bool
    {
        if (User::query()->where(['username' => $form->username])->exists()) {
            $form->getValidationResult()->addError('A user with this username already exists!', valuePath: ['username']);
            return false;
        }

        if (User::query()->where(['email' => $form->email])->exists()) {
            $form->getValidationResult()->addError('A user with this email already exists!', valuePath: ['email']);
            return false;
        }

        return true;
    }

    private function createUser(Form $form): void
    {
        $user = new User();
        $user->setUsername($form->username);
        $user->setEmail($form->email);
        $user->setPasswordHash($this->passwordHasher->hash($form->password));
        $user->setAuthKey($this->authKeyGenerator->generate());
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $this->db->transaction(
            function () use ($user) {
                $user->save();
                $this->rbacManager->assign(Role::USER->value, $user->getId());
            },
        );
    }
}
