<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Constant\ReferentialAction;
use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724161907CreateTaskTagTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%task_tag}}';
    private string $referenceTagTable = '{{%tag}}';
    private string $referenceTaskTable = '{{%task}}';

    private string $indexTag = 'idx_task_tag_tag_id';

    private string $tagRelationName = 'fk_task_tag_tag_id';
    private string $taskRelationName = 'fk_task_tag_task_id';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'tag_id' => $cb::uuid()->notNull(),
            'task_id' => $cb::uuid()->notNull(),
            'PRIMARY KEY([[tag_id]], [[task_id]])',
        ]);

        // Task foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->taskRelationName,
            'task_id',
            $this->referenceTaskTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );

        // Tag foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->tagRelationName,
            'tag_id',
            $this->referenceTagTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );

        // Index for tag_id column
        $b->createIndex(
            $this->tableName,
            $this->indexTag,
            'tag_id'
        );
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropIndex($this->tableName, $this->indexTag);

        $b->dropForeignKey($this->tableName, $this->tagRelationName);
        $b->dropForeignKey($this->tableName, $this->taskRelationName);

        $b->dropTable($this->tableName);
    }
}
