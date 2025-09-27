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
        Schema::create('vipps_recurring_agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_id')->unique()->index();
            $table->string('currency', 3)->default('NOK');
            $table->integer('price');
            $table->string('product_name');
            $table->string('product_description');
            $table->string('merchant_redirect_url');
            $table->string('merchant_agreement_url');
            $table->string('interval')->default('MONTH');
            $table->integer('interval_count')->default(1);
            $table->boolean('is_app')->default(false);
            $table->string('status')->index();
            $table->string('phone_number')->nullable();
            $table->json('user_info')->nullable();
            $table->json('campaign')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('stop_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vipps_recurring_agreements');
    }
};