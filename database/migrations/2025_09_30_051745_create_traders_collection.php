<?php

use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradersCollection extends Migration
{
    public function up()
    {
    Schema::connection('mongodb')->create('traders', function (Blueprint $collection) {
            $collection->index('trader_name');
            $collection->index('stock_name');
        });
    }

    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('traders');
    }
}
