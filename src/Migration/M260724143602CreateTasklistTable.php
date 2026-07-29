<?php

declare(strict_types=1);

namespace App\Migration;

use App\Domain\Tasklist\TasklistDifficulty;
use App\Domain\Tasklist\TasklistVisibility;
use Yiisoft\Db\Constant\IndexType;
use Yiisoft\Db\Constant\ReferentialAction;
use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724143602CreateTasklistTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%tasklist}}';
    private string $referenceUserTable = '{{%user}}';
    private string $referenceGameTable = '{{%game}}';
    private string $referenceCharacterTable = '{{%character}}';
    private string $referenceTargetTable = '{{%target}}';
    private string $referenceStatTable = '{{%stat}}';

    private string $uniqueIndexUserSlugAndTitle = 'idx_unique_tasklist_user_id_slug_title';

    private string $UserRelationName = 'fk_tasklist_user_id_user';
    private string $GameRelationName = 'fk_tasklist_game_id_game';
    private string $CharacterRelationName = 'fk_tasklist_character_id_character';
    private string $TargetRelationName = 'fk_tasklist_target_id_target';
    private string $StatRelationName = 'fk_tasklist_stat_id_stat';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'id' => $cb::uuidPrimaryKey(),
            'title' => $cb::string()->notNull(),
            'slug' => $cb::string()->notNull(),
            'user_id' => $cb::uuid()->notNull(),
            'game_id' => $cb::uuid()->notNull(),
            'difficulty' => $cb::tinyint()->notNull()->defaultValue(TasklistDifficulty::EASY->value),
            'visibility' => $cb::tinyint()->notNull()->defaultValue(TasklistVisibility::PUBLIC->value),
            'is_ordered' => $cb::boolean()->notNull()->defaultValue(false),
            'character_id' => $cb::uuid(),
            'target_id' => $cb::uuid(),
            'stat_id' => $cb::uuid(),
            'created_at' => $cb::integer()->notNull(),
            'updated_at' => $cb::integer()->notNull(),
        ]);

        // Unique index for user_id, slug and title
        $b->createIndex(
            $this->tableName,
            $this->uniqueIndexUserSlugAndTitle,
            ['user_id', 'slug', 'title'],
            IndexType::UNIQUE
        );

        // User foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->UserRelationName,
            'user_id',
            $this->referenceUserTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION,
        );

        // Game foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->GameRelationName,
            'game_id',
            $this->referenceGameTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION,
        );

        // Character foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->CharacterRelationName,
            'character_id',
            $this->referenceCharacterTable,
            'id',
            ReferentialAction::SET_NULL,
            ReferentialAction::NO_ACTION
        );

        // Target foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->TargetRelationName,
            'target_id',
            $this->referenceTargetTable,
            'id',
            ReferentialAction::SET_NULL,
            ReferentialAction::NO_ACTION
        );

        // Stat foreign key
        $b->addForeignKey(
            $this->tableName,
            $this->StatRelationName,
            'stat_id',
            $this->referenceStatTable,
            'id',
            ReferentialAction::SET_NULL,
            ReferentialAction::NO_ACTION
        );
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropIndex($this->tableName, $this->uniqueIndexUserSlugAndTitle);

        $b->dropForeignKey($this->tableName, $this->StatRelationName);
        $b->dropForeignKey($this->tableName, $this->TargetRelationName);
        $b->dropForeignKey($this->tableName, $this->CharacterRelationName);
        $b->dropForeignKey($this->tableName, $this->GameRelationName);
        $b->dropForeignKey($this->tableName, $this->UserRelationName);

        $b->dropTable($this->tableName);
    }
}
