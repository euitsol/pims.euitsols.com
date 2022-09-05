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
        Schema::create('stinfo_stacadinfo_bdts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('std_info_id');
            $table->unsignedBigInteger('academic_id');
            $table->timestamps();
        });
        Schema::table('stinfo_stacadinfo_bdts', function (Blueprint $table) {
            $table->foreign('created_by', 'user_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'user_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'user_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('student_infos_id')->references('id')->on('student_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('academic_infos_id')->references('id')->on('academic_infos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stinfo_stacadinfo_bdts');
    }
};
