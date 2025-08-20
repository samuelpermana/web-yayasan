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

            // tanggal transaksi
            $table->date('transaction_date')->nullable();

            // akun sumber/destinasi pihak ketiga (opsional)
            $table->string('paid_to_source')->nullable();

            // hubungan ke akun debit dan kredit
            $table->string('debit_account_id')->nullable();
            $table->foreign('debit_account_id')
                ->references('id')->on('accounts')
                ->onDelete('set null');

            $table->string('credit_account_id')->nullable();
            $table->foreign('credit_account_id')
                ->references('id')->on('accounts')
                ->onDelete('set null');

            // relasi ke master transaksi
            $table->foreignId('id_deposit_master')->nullable()
                ->constrained('deposit_masters')
                ->onDelete('set null');

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
