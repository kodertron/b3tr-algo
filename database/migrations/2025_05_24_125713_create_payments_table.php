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
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("plan_id")->constrained()->onDelete("cascade");
            $table->double("amount")->nullable();
            $table->string('currency')->default('USD');
            $table->string('reference');
            $table->string('status')->default('unverified');
            $table->timestamp("payed_at")->nullable();
            $table->timestamp("expires_at")->nullable();
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
