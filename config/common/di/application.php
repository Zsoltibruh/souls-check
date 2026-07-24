<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use Psr\Container\ContainerInterface;
use Yiisoft\Validator\RuleHandlerResolver\RuleHandlerContainer;
use Yiisoft\Validator\RuleHandlerResolverInterface;

/** @var array $params */

return [
    ApplicationParams::class => [
        '__construct()' => [
            'name' => $params['application']['name'],
            'charset' => $params['application']['charset'],
            'locale' => $params['application']['locale'],
        ],
    ],

    RuleHandlerResolverInterface::class => static fn(ContainerInterface $container) => new RuleHandlerContainer($container),
];
