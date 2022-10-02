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
        Schema::create('admitted_std_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_infos_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('shift_id');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('admitted_std_assigns', function (Blueprint $table) {
            $table->foreign('student_infos_id', 'admitted_std_assigns_student_infos')->references('id')->on('student_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('session_id', 'admitted_std_assigns_session')->references('id')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('semester_id', 'admitted_std_assigns_semester')->references('id')->on('semesters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group_id', 'admitted_std_assigns_group')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shift_id', 'admitted_std_assigns_shift')->references('id')->on('shifts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'admitted_std_assigns_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'admitted_std_assigns_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'admitted_std_assigns_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admitted_std_assigns');
    }
};
