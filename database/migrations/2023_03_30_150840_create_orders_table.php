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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid();
            $table->foreignId('user_id');
            $table->foreignId('payment_type_id');
            $table->string('name');
            $table->unsignedBigInteger('total_price');
            $table->unsignedBigInteger('total_paid');
            $table->unsignedBigInteger('return');
            $table->string('receipt_code');
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
