<?php

declare(strict_types=1);

/**
 * This view is used by {@see Yiisoft\Db\Migration\Command\CreateCommand}.
 *
 * @var \Yiisoft\Db\Migration\Service\Generate\PhpRenderer $this
 * @var string $className The new migration class name without namespace.
 * @var string $namespace The new migration class namespace.
 */

echo "<?php\n";
echo "\ndeclare(strict_types=1);\n";

if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class <?= $className ?> implements RevertibleMigrationInterface
{
    private string $tableName = '{{%}}';

    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();
        $b->createTable($this->tableName, [
            'id' => $cb::uuidPrimaryKey()
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable($this->tableName);
    }
}