<?php

declare(strict_types=1);

namespace App\Presentation\Access;

use App\Presentation\ResponseFactory\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\User\CurrentUser;

final readonly class CheckAccess implements MiddlewareInterface
{
    public function __construct(
        private CurrentUser $currentUser,
        private ResponseFactory $responseFactory,
        private CurrentRoute $currentRoute,
        private string $permissionName,
        private array $params = [],
        private array $routeArgumentParams = [],
    ) {}


    public static function definition(
        Permission $permission,
        array $params = [],
        array $routeArgumentParams = [],
    ): array {
        return [
            'class' => self::class,
            '__construct()' => [
                'permissionName' => $permission->value,
                'params' => $params,
                'routeArgumentParams' => $routeArgumentParams,
            ],
        ];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = $this->params;

        foreach ($this->routeArgumentParams as $ruleParamName => $routeArgumentName) {
            $params[$ruleParamName] = $this->currentRoute->getArgument($routeArgumentName);
        }

        if ($this->currentUser->can($this->permissionName, $params)) {
            return $handler->handle($request);
        }

        return $this->responseFactory->notFound(ResponseFactory::USER_NOT_FOUND);
    }
}
