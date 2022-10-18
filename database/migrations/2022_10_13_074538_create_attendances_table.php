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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger("departments_id");
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('shift_id');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('session_id', 'attendances_session')->references('id')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('departments_id', 'attendances_departments')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('semester_id', 'attendances_semesters')->references('id')->on('semesters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id', 'attendances_teachers')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id', 'attendances_subjects')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group_id', 'attendances_groups')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shift_id', 'attendances_shifts')->references('id')->on('shifts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'attendances_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'attendances_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'attendances_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
