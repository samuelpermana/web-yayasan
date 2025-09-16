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
        Schema::create('deposit_masters', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->decimal('default_amount', 15, 2)->default(0);
            $table->text('description')->nullable();

            // Relasi ke akun debit & credit → harus string
            $table->string('debit_account_id')->nullable();
            $table->string('credit_account_id')->nullable();

            // Role area
            $table->enum('role_area', ['yayasan', 'mahad'])->default('yayasan');

            $table->timestamps();

            // Foreign key ke tabel accounts (id = string)
            $table->foreign('debit_account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->foreign('credit_account_id')->references('id')->on('accounts')->onDelete('set null');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_master');
    }
};
