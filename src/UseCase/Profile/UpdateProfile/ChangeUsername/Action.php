<?php

declare(strict_types=1);

namespace App\UseCase\Profile\UpdateProfile\ChangeUsername;

use App\Domain\User\User;
use App\Presentation\ResponseFactory\ResponseFactory;
use App\Shared\UrlGenerator;
use App\UseCase\Profile\UpdateProfile\Action as UpdateProfileAction;
use App\UseCase\Shared\HasForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Router\HydratorAttribute\RouteArgument;
use Yiisoft\User\CurrentUser;

final readonly class Action
{
    use HasForm;

    private const FORM_PARTIAL = __DIR__ . '/_form';

    public function __construct(
        private CurrentUser $currentUser,
        private UrlGenerator $urlGenerator,
        private ResponseFactory $responseFactory,
        private FormHydrator $formHydrator,
        private ConnectionInterface $db,
    ) {}

    public function __invoke(#[RouteArgument('id')] string $id, ServerRequestInterface $request): ResponseInterface
    {
        if (!Uuid::isValid($id)) {
            return $this->responseFactory->notFound(ResponseFactory::USER_NOT_FOUND);
        }

        /** @var User $user */
        $user = $this->currentUser->getIdentity()->user;

        $form = new Form($user);
        if (!$this->formHydrator->populateFromPostAndValidate($form, $request) || !$this->checkUsername($form)) {
            return $this->responseFactory->renderPartial(self::FORM_PARTIAL, [
                'form' => $form,
            ]);
        }

        $this->updateUsername($form);

        return $this->responseFactory->redirectHtmx($this->urlGenerator->viewProfile($id));
    }

    public function checkUsername(Form $form): bool
    {
        if (User::query()->where(['username' => $form->username])->exists()) {
            $form->addError('A user with this username already exists!', valuePath: ['username']);
            return false;
        }

        return true;
    }

    public function updateUsername(Form $form): void
    {
        /** @var User $user */
        $user = User::query()->where(['id' => $this->currentUser->getId()])->one();
        $user->setUsername($form->username);
        $this->db->transaction(
            function () use ($user) {
                $user->save();
            }
        );
    }
}
