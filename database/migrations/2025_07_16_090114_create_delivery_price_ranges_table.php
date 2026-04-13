<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_price_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained()->onDelete('cascade');
            $table->decimal('from_sum', 10, 2)->default(0)->comment('Сумма корзины от');
            $table->decimal('to_sum', 10, 2)->nullable()->comment('Сумма корзины до');
            $table->decimal('price', 10, 2)->comment('Цена доставки');
            $table->unsignedInteger('pos')->default(1000);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_price_ranges');
    }
};
