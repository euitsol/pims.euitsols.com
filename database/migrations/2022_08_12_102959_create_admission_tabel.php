<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departments_id');
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('present_address');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('gender');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('dob');
            $table->string('Quota')->nullable();
            $table->string('nationality');
            $table->string('blood_group_name')->nullable();
            $table->string('exam_name');
            $table->string('passing_year');
            $table->string('division');
            $table->string('board');
            $table->string('roll');
            $table->string('registration_no');
            $table->string('gpa');
            $table->string('reg_card');
            $table->string('marksheet');
            $table->string('photo');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->foreign('departments_id')->references('id')->on("departments")->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_info');
    }
}