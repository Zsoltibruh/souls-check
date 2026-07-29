<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Constant\ReferentialAction;
use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724164535CreateUserSavedTasklistTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%user_saved_tasklist}}';
    private string $referenceUserTable = '{{%user}}';
    private string $referenceTasklistTable = '{{%tasklist}}';

    private string $indexTasklist = 'idx_user_saved_tasklist_tasklist_id';

    private string $UserRelationName = 'fk_user_saved_tasklist_user_id_user';
    private string $TasklistRelationName = 'fk_user_saved_tasklist_tasklist_id_tasklist';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'user_id' => $cb::uuid()->notNull(),
            'tasklist_id' => $cb::uuid()->notNull(),
            'is_completed' => $cb::boolean()->notNull()->defaultValue(false),
            'created_at' => $cb::datetime()->notNull(),
            'PRIMARY KEY([[user_id]], [[tasklist_id]])',
        ]);

        // User foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->UserRelationName,
            'user_id',
            $this->referenceUserTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );

        // Tasklist foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->TasklistRelationName,
            'tasklist_id',
            $this->referenceTasklistTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );

        // Index for tasklist_id
        $b->createIndex(
            $this->tableName,
            $this->indexTasklist,
            'tasklist_id'
        );
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropIndex($this->tableName, $this->indexTasklist);

        $b->dropForeignKey($this->tableName, $this->TasklistRelationName);
        $b->dropForeignKey($this->tableName, $this->UserRelationName);

        $b->dropTable($this->tableName);
    }
}
