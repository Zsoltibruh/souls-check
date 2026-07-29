<?php

namespace App\Shared;

use Yiisoft\Router\UrlGeneratorInterface;

final readonly class UrlGenerator
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function generate(string $name, array $arguments = [], array $queryParameters = []): string
    {
        return $this->urlGenerator->generate($name, $arguments, $queryParameters);
    }

    public function home(): string
    {
        return $this->generate('home');
    }
}
