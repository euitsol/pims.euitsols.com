<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("subject_id");
            $table->unsignedBigInteger("routine_id");
            $table->text('title');
            $table->integer('day');
            $table->date('start');
            $table->date('end');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('routine_dates', function (Blueprint $table) {
            $table->foreign('subject_id', 'routine_times_subject')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('routine_id', 'routine_times_routine')->references('id')->on('routines')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('created_by', 'routine_times_assigns_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'routine_times_assigns_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'routine_times_assigns_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routine_dates');
    }
};
