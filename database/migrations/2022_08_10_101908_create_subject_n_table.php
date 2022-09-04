<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectNTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_n', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departments_id');
            $table->string('subject_name');
            $table->string('short_name')->nullable();
            $table->timestamps();
            $table->foreign('departments_id')
                    ->references('id')
                    ->on('departments')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            // $table->foreignId('departments_id')
            //         ->constrained()
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_n');
    }
}
