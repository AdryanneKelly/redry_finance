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
        Schema::create('fixed_bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fixed_bill_id')->constrained()->cascadeOnDelete();
            $table->integer('parcel_number');
            $table->decimal('value', 15, 2);
            $table->date('due_date');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_bill_items');
    }
};
