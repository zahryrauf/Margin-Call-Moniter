<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('traders', function (Blueprint $table) {
            $table->id();
            $table->string('trader_id')->unique();
            $table->foreignId('user_id')->constrained();
            $table->string('broker_name');
            $table->string('broker_email');
            $table->string('trader_name');
            $table->string('stock_name');
            $table->decimal('current_stock_value', 15, 4);
            $table->decimal('own_money', 15, 4);
            $table->decimal('borrowed_money', 15, 4);
            $table->decimal('margin_threshold', 15, 4);
            $table->integer('current_stock_count');
            $table->decimal('initial_total_investment', 15, 4);
            $table->decimal('current_total_value', 15, 4);
            $table->decimal('equity', 15, 4);
            $table->string('status');
            $table->timestamps();

            $table->index(['trader_name']);
            $table->index(['stock_name']);
            $table->index(['broker_email']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('traders');
    }
};
