<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loan_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('interest_rate', 5, 2);
            $table->integer('min_amount');
            $table->integer('max_amount');
            $table->integer('min_duration'); // months
            $table->integer('max_duration'); // months
            $table->text('benefits')->nullable();
            $table->text('process')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_types');
    }
};
