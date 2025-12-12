<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->integer('duration'); // months
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('emi', 10, 2);
            $table->text('description')->nullable();

            $table->string('status')->default('pending'); // pending / approved / rejected

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
