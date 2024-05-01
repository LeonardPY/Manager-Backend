<?php

use App\Models\Category;
use App\Models\User;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('name');
            $table->string('name_am');

            $table->string('slug')->unique()->index();

            $table->decimal('price');
            $table->decimal('old_price')->nullable();
            $table->decimal('purchase_price')->nullable();

            $table->integer('count')->default(1);
            $table->unsignedTinyInteger('discount_percent')->default(0);

            $table->unsignedSmallInteger('status')->default(1);

            $table->foreignIdFor(Category::class)->nullable()->constrained()->OnDelete('set null');
            $table->foreignIdFor(User::class)->constrained()->OnDelete('CASCADE');
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
