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
    Schema::table('loans', function (Blueprint $table) {
        $table->foreignId('loan_type_id')
              ->after('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->decimal('interest_rate', 5, 2)->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('loans', function (Blueprint $table) {
        $table->dropForeign(['loan_type_id']);
        $table->dropColumn(['loan_type_id','interest_rate']);
    });
}

};
