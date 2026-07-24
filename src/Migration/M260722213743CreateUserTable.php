<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260722213743CreateUserTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%user}}';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'id' => $cb::uuidPrimaryKey(),
            'username' => $cb::string()->unique()->notNull(),
            'email' => $cb::string()->unique()->notNull(),
            'password_hash' => $cb::string()->notNull(),
            'status' => $cb::tinyint()->notNull(),
            'auth_key' => $cb::string(64)->notNull(),
            'created_at' => $cb::integer()->notNull(),
            'updated_at' => $cb::integer()->notNull()
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable($this->tableName);
    }
}
