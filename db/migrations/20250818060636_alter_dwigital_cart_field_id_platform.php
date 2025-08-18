<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterDwigitalCartFieldIdPlatform extends AbstractMigration
{
    public function up()
    {
        $this->table('dwigital_cart')
            ->addColumn('id_platform', 'integer')
            ->addIndex('id_platform')
            ->save();
    }

    public function down()
    {
        $this->table('dwigital_cart')
            ->removeColumn('id_platform')
            ->save();
    }
}
