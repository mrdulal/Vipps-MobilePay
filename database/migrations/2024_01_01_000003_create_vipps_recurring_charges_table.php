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
        Schema::create('vipps_recurring_charges', function (Blueprint $table) {
            $table->id();
            $table->string('charge_id')->unique()->index();
            $table->string('agreement_id')->index();
            $table->integer('amount');
            $table->string('currency', 3)->default('NOK');
            $table->string('description');
            $table->string('order_id');
            $table->string('status')->index();
            $table->timestamp('due_date')->nullable();
            $table->integer('retry_days')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();

            $table->foreign('agreement_id')->references('agreement_id')->on('vipps_recurring_agreements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vipps_recurring_charges');
    }
};