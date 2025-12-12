<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->integer('installment_number')->unsigned(); // 1,2,3...
            $table->date('due_date');
            $table->decimal('amount', 12, 2); // total EMI amount
            $table->decimal('principal', 12, 2)->nullable();
            $table->decimal('interest', 12, 2)->nullable();
            $table->decimal('late_fee', 12, 2)->default(0);
            $table->enum('status', ['pending','paid','overdue'])->default('pending');
            $table->decimal('paid_amount', 12, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['loan_id','installment_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
