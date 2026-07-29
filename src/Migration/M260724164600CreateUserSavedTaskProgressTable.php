<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Constant\ReferentialAction;
use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724164600CreateUserSavedTaskProgressTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%user_saved_task_progress}}';
    private string $referenceUserTable = '{{%user}}';
    private string $referenceTaskTable = '{{%task}}';

    private string $indexTask = 'idx_user_saved_task_progress_task_id';

    private string $UserRelationName = 'fk_user_saved_task_progress_user_id_user';
    private string $TaskRelationName = 'fk_user_saved_task_progress_task_id_task';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'user_id' => $cb::uuid()->notNull(),
            'task_id' => $cb::uuid()->notNull(),
            'is_completed' => $cb::boolean()->notNull()->defaultValue(false),
            'completed_at' => $cb::datetime(),
            'PRIMARY KEY([[user_id]], [[task_id]])',
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

        // Task foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->TaskRelationName,
            'task_id',
            $this->referenceTaskTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );

        // Index for task_id
        $b->createIndex(
            $this->tableName,
            $this->indexTask,
            'task_id'
        );
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropIndex($this->tableName, $this->indexTask);

        $b->dropForeignKey($this->tableName, $this->TaskRelationName);
        $b->dropForeignKey($this->tableName, $this->UserRelationName);

        $b->dropTable($this->tableName);
    }
}
