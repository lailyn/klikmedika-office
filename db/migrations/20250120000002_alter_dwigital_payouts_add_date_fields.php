<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterDwigitalPayoutsAddDateFields extends AbstractMigration
{
    public function change(): void
    {
        $this->table('dwigital_payouts')
            ->addColumn('start_date', 'date', ['null' => false, 'after' => 'payout_to'])
            ->addColumn('end_date', 'date', ['null' => false, 'after' => 'start_date'])
            ->update();
    }
}
