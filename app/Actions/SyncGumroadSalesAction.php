<?php

namespace App\Actions;

use App\Models\GumroadSync;
use App\Models\Product;
use App\Models\Sale;
use App\Services\Gumroad\DataTransferObjects\SaleData;
use App\Services\Gumroad\GumroadService;

class SyncGumroadSalesAction
{
    public function __construct(
        private readonly SyncGumroadProductsAction $syncGumroadProducts,
        private readonly GumroadService $gumroad,
    ) {}

    public function execute(): void
    {
        $this->syncGumroadProducts->execute();

        $latestSync = GumroadSync::latest('synced_at')->first();

        $sales = $this->gumroad->sales(
            Product::all(),
            $latestSync?->synced_at,
        );

        foreach ($sales as $sale) {
            /** @var SaleData $sale */
            $product = Product::where('gumroad_id', $sale->product->gumroad_id)->first();

            Sale::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'customer_email' => $sale->email,
                ],
                [
                    'product_id' => $product->id,
                    'customer_email' => $sale->email,
                    'customer_name' => $sale->full_name,
                    'revenue' => $sale->revenue,
                    'sold_at' => $sale->date,
                ]
            );
        }

        // To be able to sync more than once a day I need to subtract a day because Gumroad only accept Y-m-d format
        GumroadSync::create([
            'synced_at' => Sale::latest('sold_at')->first()->sold_at->subDay(),
        ]);
    }
}
