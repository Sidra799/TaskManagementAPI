<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->unsignedBigInteger('fromUid');
            $table->foreign('fromUid')->references('id')->on('users')->onDelete('cascade');;
            
            $table->unsignedBigInteger('toUid');
            $table->foreign('toUid')->references('id')->on('users')->onDelete('cascade');;
            $table->unsignedBigInteger('taskId');
            $table->foreign('taskId')->references('id')->on('tasks')->onDelete('cascade');;
            $table->softDeletes();

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
        Schema::dropIfExists('queries');
    }

}
