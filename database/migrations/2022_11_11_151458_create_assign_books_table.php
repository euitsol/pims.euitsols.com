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
        Schema::create('assign_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('std_id');
            $table->integer('total_book');
            $table->timestamp('assign_date');
            $table->string('return_date');
            $table->string('status');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('assign_books', function (Blueprint $table) {
            $table->foreign('std_id', 'assign_books_std')->references('id')->on('library_students')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('book_id', 'assign_books_book')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'assign_books_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'assign_books_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'assign_books_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_books');
    }
};
