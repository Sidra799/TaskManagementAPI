<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('password');
            $table->string('passwordToken')->nullable();
            $table->timestamp('passwordTokenTime')->nullable();
            $table->string('type');
            $table->string('name');
            $table->string('gender');
            $table->integer('parent')->nullable();
            $table->string('designation')->nullable();
            $table->string('token_id')->nullable();
            $table->integer('status');
            $table->string('activationcode')->nullable();
            $table->timestamp('last_logged_in')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authusers');
    }
}
