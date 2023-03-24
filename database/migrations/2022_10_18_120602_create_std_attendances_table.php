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
        Schema::create('std_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_infos_id');
            $table->unsignedBigInteger('attendance_id');
            $table->string('class');
            $table->string('date');
            $table->string('attendance');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('std_attendances', function (Blueprint $table) {
            $table->foreign('student_infos_id', 'std_attendances_student_infos')->references('id')->on('student_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('attendance_id', 'std_attendances_attendance')->references('id')->on('attendances')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'std_attendances_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'std_attendances_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'std_attendances_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('std_attendances');
    }
};
