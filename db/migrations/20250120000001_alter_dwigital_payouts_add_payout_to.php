<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterDwigitalPayoutsAddPayoutTo extends AbstractMigration
{
    public function change(): void
    {
        $this->table('dwigital_payouts')
            ->addColumn('payout_to', 'string', ['limit' => 100, 'null' => false, 'after' => 'id'])
            ->removeColumn('platform_id')
            ->update();
    }
}


