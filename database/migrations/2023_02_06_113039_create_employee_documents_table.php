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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_infos_id');
            $table->unsignedBigInteger('designation_id');
            $table->string('nid_or_dob');
            $table->string('cv');
            $table->string('character_certificate');
            $table->timestamps();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('employee_documents', function (Blueprint $table) {
            $table->foreign('employee_infos_id', 'employee_documents_employee_infos')->references('id')->on('employee_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('designation_id', 'employee_designation')->references('id')->on('designations')->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('created_by', 'employee_documents_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'employee_documents_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'employee_documents_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_documents');
    }
};
