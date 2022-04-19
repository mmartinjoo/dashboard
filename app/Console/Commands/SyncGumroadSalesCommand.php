<?php

namespace App\Console\Commands;

use App\Actions\SyncGumroadSalesAction;
use Illuminate\Console\Command;

class SyncGumroadSalesCommand extends Command
{
    protected $signature = 'sync';
    protected $description = 'Sync sales and products from Gumroad';

    public function handle(SyncGumroadSalesAction $syncGumroadSales)
    {
        $syncGumroadSales->execute();

        return self::SUCCESS;
    }
}
