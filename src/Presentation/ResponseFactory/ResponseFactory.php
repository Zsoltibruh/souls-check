<?php

namespace App\Presentation\ResponseFactory;

use App\Presentation\Layout\Layout;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\ResponseFactory\HtmlResponseFactory;
use Yiisoft\Http\Header;
use Yiisoft\Http\Status;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class ResponseFactory implements ResponseFactoryInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private WebViewRenderer $viewRenderer,
    ) {}

    #[Override]
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->responseFactory->createResponse($code, $reasonPhrase);
    }

    public function redirect(string $url, ?ResponseInterface $response = null): ResponseInterface
    {
        return ($response ?? $this->createResponse())
            ->withStatus(Status::FOUND)
            ->withHeader(Header::LOCATION, $url);
    }

    public function notFound(string $title = 'Page not found', string $description = ''): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout(Layout::ERROR)
            ->render(__DIR__ . '/not-found.php', ['title' => $title, 'description' => $description])
            ->withStatus(Status::NOT_FOUND);
    }

    public function accessDenied(): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout(Layout::ERROR)
            ->render(__DIR__ . '/access-denied.php')
            ->withStatus(Status::FORBIDDEN);
    }
}
