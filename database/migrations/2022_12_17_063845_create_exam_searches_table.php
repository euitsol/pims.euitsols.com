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
        Schema::create('exam_searches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger('semester_id');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('exam_searches', function (Blueprint $table) {
            $table->foreign('session_id', 'exam_searches_session')->references('id')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('department_id', 'exam_searches_department')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('semester_id', 'exam_searches_semester')->references('id')->on('semesters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'exam_searches_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'exam_searches_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'exam_searches_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_searches');
    }
};
