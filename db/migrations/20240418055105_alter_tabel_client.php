<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterTabelClient extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->table('md_client')
            ->addColumn('tgl_invoice', 'integer', [
                'null' => true,
                'after' => 'tgl_kadaluarsa'
            ])            
            ->save();
    }

    public function down()
    {
        $this->table('md_client')
            ->removeColumn('tgl_invoice')                        
            ->save();
    }
}
