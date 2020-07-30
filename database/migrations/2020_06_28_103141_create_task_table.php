<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('createdBy');
            $table->foreign('createdBy')->references('id')->on('users')->onDelete('cascade');;
            $table->timestamp('startDate')->nullable();
            $table->timestamp('endDate')->nullable();
            

            $table->string('priority');
            $table->string('description');
            $table->unsignedBigInteger('assignedUserId');
            $table->foreign('assignedUserId')->references('id')->on('users');

            $table->unsignedBigInteger('statusId');
            $table->foreign('statusId')->references('id')->on('statuses');
            
            $table->string('durationUnit');
            $table->integer('duration');
            $table->string('image')->nullable();
            $table->string('imagePath')->nullable();
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
        Schema::dropIfExists('tasks');
    }
   }
