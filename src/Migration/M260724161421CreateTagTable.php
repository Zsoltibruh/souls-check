<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724161421CreateTagTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%tag}}';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'id' => $cb::uuidPrimaryKey(),
            'type' => $cb::tinyint()->notNull(),
            'name' => $cb::string()->notNull(),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable($this->tableName);
    }
}
