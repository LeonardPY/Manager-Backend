<?php

use App\Enums\Currencies;
use App\Enums\OrderStatus;
use App\Models\User;
use App\Models\UserAddress;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(UserAddress::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained('users')->onDelete('set null');

            $table->integer('status')->default(OrderStatus::IN_CART->value);

            $table->json('shipping_data')->nullable();

            $table->decimal('total_price')->nullable();
            $table->string('currency')->default(Currencies::AMD->value);
            $table->decimal('shipping_cost')->default(0.00);
            $table->decimal('insurance_cost')->default(0.00);
            $table->decimal('refunded_price')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
