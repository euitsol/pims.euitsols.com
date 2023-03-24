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
        Schema::create('employee_academic_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_infos_id');
            $table->unsignedBigInteger('exam_id');
            $table->string('passing_year');
            $table->string('group');
            $table->unsignedBigInteger('board_id');
            $table->integer('roll')->unique();
            $table->integer('reg_no')->unique();
            $table->string('gpa');
            $table->string('reg_card');
            $table->string('marksheet');
            $table->string('certificate');
            $table->timestamps();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('employee_academic_infos', function (Blueprint $table) {
            $table->foreign('employee_infos_id', 'employee_academic_infos_employee_infos')->references('id')->on('employee_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('exam_id', 'employee_academic_infos_exam')->references('id')->on('eadmissions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('board_id', 'employee_academic_infos_board')->references('id')->on('boards')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'employee_academic_infos_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'employee_academic_infos_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'employee_academic_infos_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_academic_infos');
    }
};
