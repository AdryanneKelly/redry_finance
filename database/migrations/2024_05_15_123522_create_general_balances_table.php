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
        Schema::create('general_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('related_month');
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('fixed_bills_total', 15, 2)->default(0);
            $table->decimal('recurring_bills_total', 15, 2)->default(0);
            $table->decimal('variant_bills_total', 15, 2)->default(0);
            $table->decimal('total_bills', 15, 2)->default(0);
            $table->decimal('available_balance', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_balances');
    }
};
