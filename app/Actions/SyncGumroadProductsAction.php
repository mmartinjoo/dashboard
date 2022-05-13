<?php

namespace App\Actions;

use App\Models\Product;
use App\Services\Gumroad\GumroadService;

class SyncGumroadProductsAction
{
    public function __construct(private readonly GumroadService $gumroad)
    {
    }

    public function execute(): void
    {
        foreach ($this->gumroad->products() as $product) {
            $title = $product->name;

            if (str($product->name)->contains('Package')) {
                $title = str($product->name)->after('- ')->before('Package');
            }

            Product::updateOrCreate(
                [
                    'gumroad_id' => $product->id,
                ],
                [
                    'gumroad_id' => $product->id,
                    'title' => $title,
                ]
            );
        }
    }
}
