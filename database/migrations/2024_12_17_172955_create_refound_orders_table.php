<?php

use App\Enums\Currencies;
use App\Models\Order;
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
        Schema::create('refund_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->integer('status')->default(1);
            $table->json('shipping_data')->nullable();
            $table->decimal('total_price')->nullable();
            $table->string('currency')->default(Currencies::AMD->value);
            $table->decimal('refunded_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_orders');
    }
};
