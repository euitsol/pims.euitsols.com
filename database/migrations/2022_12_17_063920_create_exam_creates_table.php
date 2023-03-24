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
        Schema::create('exam_creates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('search_id');
            $table->unsignedBigInteger('type_id');
            $table->float('total_mark');
            $table->float('duration');
            $table->enum('hour_minute',[1,2])->default(2);
            $table->float('total_fee');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('exam_creates', function (Blueprint $table) {
            $table->foreign('search_id', 'exam_creates_search')->references('id')->on('exam_searches')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_id', 'exam_creates_type')->references('id')->on('exam_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'exam_creates_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'exam_creates_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'exam_creates_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_creates');
    }
};
