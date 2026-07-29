<?php

declare(strict_types=1);

namespace App\Migration;

use App\Domain\Task\TaskType;
use Yiisoft\Db\Constant\IndexType;
use Yiisoft\Db\Constant\ReferentialAction;
use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724152133CreateTaskTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%task}}';
    private string $referenceTasklistTable = '{{%tasklist}}';
    private string $referenceTargetTable = '{{%target}}';

    private string $uniqueIndexTasklistAndTarget = 'unique_index_task_tasklist_id_target';

    private string $TasklistRelationName = '{{%fk_task_tasklist_id_tasklist}}';
    private string $TargetRelationName = '{{%fk_task_target_target}}';
    private string $RequiredWeaponRelationName = '{{%fk_task_required_weapon_target}}';
    private string $RequiredSpellRelationName = '{{%fk_task_required_spell_target}}';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'id' => $cb::uuidPrimaryKey(),
            'tasklist_id' => $cb::uuid()->notNull(),
            'type' => $cb::tinyint()->notNull(),
            'target' => $cb::uuid()->notNull(),
            'required_weapon' => $cb::uuid(),
            'required_spell' => $cb::uuid(),
            'created_at' => $cb::integer()->notNull(),
            'updated_at' => $cb::integer()->notNull()
        ]);

        // Unique index for tasklist_id and target
        $b->createIndex(
            $this->tableName,
            $this->uniqueIndexTasklistAndTarget,
            ['tasklist_id', 'target'],
            IndexType::UNIQUE
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

        // Target foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->TargetRelationName,
            'target',
            $this->referenceTargetTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );

        // Required weapon foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->RequiredWeaponRelationName,
            'required_weapon',
            $this->referenceTargetTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );

        // Required spell foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->RequiredSpellRelationName,
            'required_spell',
            $this->referenceTargetTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION
        );
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropIndex($this->tableName, $this->uniqueIndexTasklistAndTarget);

        $b->dropForeignKey($this->tableName, $this->RequiredSpellRelationName);
        $b->dropForeignKey($this->tableName, $this->RequiredWeaponRelationName);
        $b->dropForeignKey($this->tableName, $this->TargetRelationName);
        $b->dropForeignKey($this->tableName, $this->TasklistRelationName);

        $b->dropTable($this->tableName);
    }
}
