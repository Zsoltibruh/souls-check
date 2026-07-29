<?php

declare(strict_types=1);

namespace App\Infrastructure;


use Override;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Cache\File\FileCache;
use Yiisoft\Db\Cache\SchemaCache;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Migration\Service\MigrationService;
use Yiisoft\Db\Pgsql\Connection;
use Yiisoft\Db\Pgsql\Driver;
use Yiisoft\Db\Pgsql\Dsn;
use Yiisoft\Di\ServiceProviderInterface;

final readonly class ServiceProvider implements ServiceProviderInterface
{
    #[Override]
    public function getDefinitions(): array
    {
        return [
            ConnectionInterface::class => static fn(Aliases $aliases) => new Connection(
                new Driver(
                    new Dsn('pgsql', 'db', 'souls-check'),
                    username: 'user',
                    password: 'password',
                ),
                new SchemaCache(
                    new FileCache($aliases->get('@runtime/cache/db')),
                )
            ),

            MigrationService::class => [
                'setNewMigrationNamespace()' => ['App\\Migration'],
                'setSourceNamespaces()' => [['App\\Migration']],
                'setSourcePaths()' => [
                    [
                        dirname(__DIR__, 2) . '/vendor/yiisoft/rbac-db/migrations/assignments',
                    ],
                ]
            ],
        ];
    }

    #[Override]
    public function getExtensions(): array
    {
        return [];
    }
}
