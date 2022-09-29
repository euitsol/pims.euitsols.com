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
        Schema::create('academic_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_infos_id');
            $table->unsignedBigInteger('exam_id');
            $table->string('passing_year');
            $table->string('group');
            $table->unsignedBigInteger('board_id');
            $table->integer('roll')->unique();
            $table->integer('reg_no')->unique();
            $table->string('gpa');
            $table->string('reg_card');
            $table->string('marksheet');
            $table->timestamps();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('academic_infos', function (Blueprint $table) {
            $table->foreign('student_infos_id', 'academic_infos_student_infos')->references('id')->on('student_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('exam_id', 'academic_infos_exam')->references('id')->on('eadmissions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('board_id', 'academic_infos_board')->references('id')->on('boards')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'academic_infos_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'academic_infos_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'academic_infos_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_infos');
    }
};
