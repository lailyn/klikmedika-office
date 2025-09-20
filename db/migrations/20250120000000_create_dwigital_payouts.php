<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDwigitalPayouts extends AbstractMigration
{
    public function change(): void
    {
        $this->table('dwigital_payouts')
            ->addColumn('platform_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('amount', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('status', 'string', ['limit' => 20, 'default' => 'pending'])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_by', 'integer', ['limit' => 10, 'null' => true])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_by', 'integer', ['limit' => 10, 'null' => true])
            ->addIndex(['platform_id'])
            ->addIndex(['status'])
            ->addIndex(['created_at'])
            ->create();
    }
}
