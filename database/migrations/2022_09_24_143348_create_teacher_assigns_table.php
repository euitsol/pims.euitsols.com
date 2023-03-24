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
        Schema::create('teacher_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_assign_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('teacher_assigns', function (Blueprint $table) {
            $table->foreign('subject_assign_id', 'teacher_assigns_subject_assign')->references('id')->on('subject_assigns')->onDelete('cascade')->onUpdate('cascade');
             $table->foreign('teacher_id', 'teacher_assigns_teacher')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shift_id', 'teacher_assigns_shift')->references('id')->on('shifts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group_id', 'teacher_assigns_group')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'teacher_assigns_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'teacher_assigns_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'teacher_assigns_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_assigns');
    }
};
