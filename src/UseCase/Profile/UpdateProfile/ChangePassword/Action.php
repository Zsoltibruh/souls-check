<?php

namespace App\UseCase\Profile\UpdateProfile\ChangePassword;

use App\Domain\User\User;
use App\Presentation\ResponseFactory\ResponseFactory;
use App\Shared\UrlGenerator;
use App\UseCase\Shared\HasForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Router\HydratorAttribute\RouteArgument;
use Yiisoft\Security\PasswordHasher;
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
        private PasswordHasher $passwordHasher,
        private ConnectionInterface $db,
    ) {}

    public function __invoke(#[RouteArgument('id')] string $id, ServerRequestInterface $request): ResponseInterface
    {
        if (!Uuid::isValid($id)) {
            return $this->responseFactory->notFound(ResponseFactory::USER_NOT_FOUND);
        }

        /** @var User $user */
        $user = $this->currentUser->getIdentity()->user;

        $form = new Form();
        if (!$this->formHydrator->populateFromPostAndValidate($form, $request)) {
            return $this->responseFactory->renderPartial(self::FORM_PARTIAL, [
                'form' => $form,
            ]);
        }

        $this->updatePassword($form);

        return $this->responseFactory->redirectHtmx($this->urlGenerator->viewProfile($id));
    }

    private function updatePassword(Form $form): void
    {
        /** @var User $user */
        $user = User::query()->where(['id' => $this->currentUser->getId()])->one();
        $user->setPasswordHash($this->passwordHasher->hash($form->password));
        $this->db->transaction(
            function () use ($user) {
                $user->save();
            }
        );
    }
}
