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
        Schema::create('assign_book_bkdns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assign_book_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('qty');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('assign_book_bkdns', function (Blueprint $table) {
            $table->foreign('assign_book_id', 'assign_book_bkdns_assign_book')->references('id')->on('assign_books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('book_id', 'assign_book_bkdns_book')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'assign_book_bkdns_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'assign_book_bkdns_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'assign_book_bkdns_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_book_bkdns');
    }
};
