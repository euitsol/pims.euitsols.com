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
        Schema::create('library_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('std_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('member_id');
            $table->string('name');
            $table->string('phone');
            $table->string('dob');
            $table->text('present_address');
            $table->text('permanent_address');
            $table->string('ec_name')->nullable();
            $table->string('ec_phone')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('library_members', function (Blueprint $table) {
            $table->foreign('std_id', 'library_members_std')->references('id')->on('student_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id', 'library_members_teacher')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'library_members_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'library_members_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'library_members_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('library_members');
    }
};
