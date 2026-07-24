<?php

declare(strict_types=1);

use Yiisoft\Db\Migration\Service\Generate\CreateService;

return [
    CreateService::class => [
        'setTemplate()' => [
            'create',
            dirname(__DIR__, 3) . '/resources/migration-templates/migration.php'
        ]
    ]
];
