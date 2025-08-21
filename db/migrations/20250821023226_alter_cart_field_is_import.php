<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterCartFieldIsImport extends AbstractMigration
{
    public function up()
    {
        $this->table('dwigital_cart')
            ->addColumn('id_import', 'integer')
            ->addColumn('import_at', 'datetime', ['default' => null, 'null' => true])
            ->addIndex('id_import')
            ->save();
    }

    public function down()
    {
        $this->table('dwigital_cart')
            ->removeColumn('id_import')
            ->removeColumn('import_at')
            ->save();
    }
}
