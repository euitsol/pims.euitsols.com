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
        Schema::create('employee_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_infos_id')->nullable();
            $table->string('designation')->nullable();
            $table->string('company_name')->nullable();
            $table->string("job_start")->nullable();
            $table->string("job_end")->nullable();
            $table->string('ex_certificate')->nullable();
            $table->timestamps();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('employee_experiences', function (Blueprint $table) {
            $table->foreign('employee_infos_id', 'employee_experiences_employee_infos')->references('id')->on('employee_infos')->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('created_by', 'employee_experiences_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'employee_experiences_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'employee_experiences_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_experiences');
    }
};
