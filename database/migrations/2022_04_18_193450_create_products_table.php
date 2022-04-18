<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('gumroad_id');
            $table->timestamps();
        });

        $ids = explode(',', config('services.gumroad.product_ids'));
        $titles = explode(',', config('services.gumroad.product_titles'));

        foreach ($ids as $i => $gumroadId) {
            Product::create([
                'gumroad_id' => $gumroadId,
                'title' => $titles[$i],
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
