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
        Schema::create('add_books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('author_name');
            $table->integer('qty');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('bookshelf_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('add_books', function (Blueprint $table) {
            $table->foreign('category_id', 'add_books_category')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bookshelf_id', 'add_books_bookshelf')->references('id')->on('bookshelves')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'add_books_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'add_books_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'add_books_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_books');
    }
};
