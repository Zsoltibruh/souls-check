<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260723155551CreateGameTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%game}}';
    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'id' => $cb::uuidPrimaryKey(),
            'title' => $cb::string()->unique()->notNull(),
            'slug' => $cb::string()->unique()->notNull(),
            'cover_image' => $cb::string()->notNull(),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable($this->tableName);
    }
}
