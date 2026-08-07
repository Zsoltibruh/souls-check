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

    public function viewProfile(string $id): string
    {
        return $this->generate('view-profile', ['id' => $id]);
    }

    public function updateProfile(string $id): string
    {
        return $this->generate('update-profile', ['id' => $id]);
    }

    public function updateUsername(string $id): string
    {
        return $this->generate('update-username', ['id' => $id]);
    }

    public function updatePassword(string $id): string
    {
        return $this->generate('update-password', ['id' => $id]);
    }

    public function updateEmail(string $id): string
    {
        return $this->generate('update-email', ['id' => $id]);
    }
}
