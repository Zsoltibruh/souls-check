<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Constant\ReferentialAction;
use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260724132607CreateClassTable implements RevertibleMigrationInterface
{
    private string $tableName = '{{%class}}';
    private string $referenceGameTable = '{{%game}}';
    private string $gameRelationName = 'fk_class_game_id_game';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'id' => $cb::uuidPrimaryKey(),
            'game_id' => $cb::uuid()->notNull(),
            'name' => $cb::string()->unique()->notNull(),
        ]);

        $b->addForeignKey(
            $this->tableName,
            $this->gameRelationName,
            'game_id',
            $this->referenceGameTable,
            'id',
            ReferentialAction::CASCADE,
            ReferentialAction::NO_ACTION,
        );
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropForeignKey($this->tableName, $this->gameRelationName);

        $b->dropTable($this->tableName);
    }
}
