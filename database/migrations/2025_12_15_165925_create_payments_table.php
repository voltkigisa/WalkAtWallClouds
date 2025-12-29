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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method');
            $table->string('payment_reference')->nullable();
            $table->string('transaction_id')->nullable(); // Midtrans transaction ID
            $table->string('snap_token')->nullable(); // Snap token untuk payment popup
            $table->text('payment_data')->nullable(); // JSON untuk store full response
            $table->integer('amount');
            $table->enum('status', ['pending','paid','success','failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
