<?php

use App\Models\Product;
use App\Models\RefundOrder;
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
        Schema::create('refund_order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RefundOrder::class)->constrained()->onDelete('CASCADE');
            $table->foreignIdFor(Product::class)->nullable()->constrained()->onDelete('set null');
            $table->unsignedBigInteger('quantity')->default(1);
            $table->decimal('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_order_products');
    }
};
