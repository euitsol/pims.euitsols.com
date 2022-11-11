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
        Schema::create('book_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('std_id');
            $table->unsignedBigInteger('book_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('book_assigns', function (Blueprint $table) {
            $table->foreign('std_id', 'book_assigns_std')->references('id')->on('library_students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('book_id', 'book_assigns_book')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'book_assigns_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'book_assigns_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'book_assigns_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_assigns');
    }
};
