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

    public function signup(): string
    {
        return $this->generate('signup');
    }

    public function login(): string
    {
        return $this->generate('login');
    }

    public function logout(): string
    {
        return $this->generate('logout');
    }
}
