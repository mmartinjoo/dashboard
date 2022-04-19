<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gumroad_syncs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('synced_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gumroad_syncs');
    }
};
