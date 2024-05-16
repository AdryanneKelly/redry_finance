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
        Schema::create('general_balance_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_balance_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('value', 15, 2)->default(0);
            $table->date('entry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_balance_entries');
    }
};
