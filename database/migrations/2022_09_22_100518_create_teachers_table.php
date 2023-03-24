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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("departments_id");
            $table->unsignedBigInteger("divisions_id");
            $table->unsignedBigInteger("districts_id");
            $table->unsignedBigInteger("bloodgroups_id");
            $table->string("date_of_birth");
            $table->string("phone")->unique();
            $table->string("email")->unique();
            $table->string("nid")->unique();
            $table->string("gender");
            $table->text("present_address")->nullable();
            $table->text("permanant_address")->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->foreign('departments_id', 'teachers_departments')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('divisions_id', 'teachers_divisions')->references('id')->on('divisions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('districts_id', 'teachers_districts')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bloodgroups_id', 'teachers_bloodgroups')->references('id')->on('bloodgroups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'teachers_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'teachers_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'teachers_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
};
