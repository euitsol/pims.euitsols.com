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
        Schema::create('exam_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('create_id');
            $table->unsignedBigInteger('subject_id');
            $table->date('exam_date')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('exam_subjects', function (Blueprint $table) {
            $table->foreign('create_id',  'exam_subjects_create')->references('id')->on('exam_creates')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id', 'exam_subjects_subject')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'exam_subjects_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'exam_subjects_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'exam_subjects_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_subjects');
    }
};
