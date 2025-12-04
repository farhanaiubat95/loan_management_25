<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable();
        $table->date('dob')->nullable();
        $table->string('nid')->nullable();
        $table->string('nid_image')->nullable();
        $table->string('address')->nullable();
        $table->string('occupation')->nullable();
        $table->decimal('income', 10, 2)->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'phone',
            'dob',
            'nid',
            'nid_image',
            'address',
            'occupation',
            'income',
        ]);
    });
}

};
