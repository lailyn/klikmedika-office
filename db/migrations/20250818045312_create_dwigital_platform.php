<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDwigitalPlatform extends AbstractMigration
{
    public function change(): void
    {
        $this->table('dwigital_platform')
            ->addColumn('nama', 'string', ['limit' => 100])
            ->addColumn('deskripsi', 'text', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
