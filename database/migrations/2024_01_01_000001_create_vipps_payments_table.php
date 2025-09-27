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
        Schema::create('vipps_payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique()->index();
            $table->string('payment_method')->default('WALLET');
            $table->string('user_flow')->default('WEB_REDIRECT');
            $table->integer('amount');
            $table->string('currency', 3)->default('NOK');
            $table->string('status')->index();
            $table->string('description');
            $table->string('redirect_url');
            $table->json('user_info')->nullable();
            $table->string('reference')->nullable();
            $table->json('transaction_info')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vipps_payments');
    }
};