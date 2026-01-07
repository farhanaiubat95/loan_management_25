<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bank_id')
                  ->constrained('banks')
                  ->cascadeOnDelete();

            $table->string('account_name');          // e.g. Loan Disbursement
            $table->string('account_number')->unique();
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->string('currency', 10)->default('BDT');

            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
