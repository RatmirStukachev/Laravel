<?php

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductGroup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('h1')->nullable();
            $table->string('article')->nullable()->index();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->text('desc')->nullable();
            $table->text('add_desc')->nullable();
            $table->bigInteger('balance')->nullable();
            $table->string('image')->nullable();
            $table->json('add_images')->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(Brand::class)->nullable();
            $table->text('content')->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_hit')->default(false);
            $table->integer('pos')->default(1000)->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
