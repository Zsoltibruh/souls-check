<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Constant\ReferentialAction;
use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724161915CreateTasklistTagTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%tasklist_tag}}';
    private string $referenceTagTable = '{{%tag}}';
    private string $referenceTasklistTable = '{{%tasklist}}';

    private string $indexTag = 'idx_tasklist_tag_tag_id';

    private string $tagRelationName = 'fk_task_tag_tag_id';
    private string $tasklistRelationName = 'fk_tasklist_tag_task_id';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'tag_id' => $cb::uuid()->notNull(),
            'tasklist_id' => $cb::uuid()->notNull(),
            'PRIMARY KEY([[tag_id]], [[tasklist_id]])',
        ]);

        // Tasklist foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->tasklistRelationName,
            'tasklist_id',
            $this->referenceTasklistTable,
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
        $b->dropForeignKey($this->tableName, $this->tasklistRelationName);

        $b->dropTable($this->tableName);
    }
}
