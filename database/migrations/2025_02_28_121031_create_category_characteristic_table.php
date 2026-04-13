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
        Schema::create('category_characteristic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('characteristic_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('in_filter')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->index(['category_id', 'characteristic_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_characteristic');
    }
};
