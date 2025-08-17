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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->foreignId('paid_to_source')->nullable()->constrained('accounts')->onDelete('set null');
            $table->foreignId('id_deposit_master')->nullable()->constrained('deposit_master')->onDelete('set null');
            $table->enum('type', ['Expense', 'Income']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
