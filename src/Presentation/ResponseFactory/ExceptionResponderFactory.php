<?php

namespace App\Presentation\ResponseFactory;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\ErrorHandler\Middleware\ExceptionResponder;
use Yiisoft\Injector\Injector;

final readonly class ExceptionResponderFactory
{
    public function __construct(
        private ResponseFactoryInterface $psrResponseFactory,
        private ResponseFactory $siteResponseFactory,
        private Injector $injector,
    ) {}

    public function create(): ExceptionResponder
    {
        return new ExceptionResponder(
            [
                PageNotFoundException::class => $this->pageNotFound(...),
            ],
            $this->psrResponseFactory,
            $this->injector
        );
    }

    public function pageNotFound(PageNotFoundException $exception): ResponseInterface
    {
        return $this->siteResponseFactory->notFound(
            $exception->title,
            $exception->description
        );
    }
}
