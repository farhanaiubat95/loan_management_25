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

        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable();
        }
        if (!Schema::hasColumn('users', 'dob')) {
            $table->date('dob')->nullable();
        }
        if (!Schema::hasColumn('users', 'nid')) {
            $table->string('nid')->nullable();
        }
        if (!Schema::hasColumn('users', 'nid_image')) {
            $table->string('nid_image')->nullable();
        }
        if (!Schema::hasColumn('users', 'address')) {
            $table->text('address')->nullable();
        }
        if (!Schema::hasColumn('users', 'occupation')) {
            $table->string('occupation')->nullable();
        }
        if (!Schema::hasColumn('users', 'income')) {
            $table->double('income')->nullable();
        }
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('user');
        }
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
