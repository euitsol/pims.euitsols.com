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
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('create_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('exam_shift_id');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('exam_schedules', function (Blueprint $table) {
            $table->foreign('create_id', 'exam_schedules_create')->references('id')->on('exam_creates')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shift_id', 'exam_schedules_shift')->references('id')->on('shifts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group_id', 'exam_schedules_group')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('exam_shift_id', 'exam_schedules_exam_shift')->references('id')->on('exam_shifts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'exam_schedules_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'exam_schedules_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'exam_schedules_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_schedules');
    }
};
