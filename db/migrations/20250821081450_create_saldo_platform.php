<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSaldoPlatform extends AbstractMigration
{
    public function change(): void
    {
        $this->table('dwigital_saldo_platform')
            ->addColumn('nama', 'string', ['limit' => 100])
            ->addColumn('sisa_saldo', 'integer')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
