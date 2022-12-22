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
        Schema::create('main_assign_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('subcat_id');
            $table->unsignedBigInteger('supplier_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('assign_products', function (Blueprint $table) {
            $table->foreign('product_id', 'assign_products_product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cat_id', 'assign_products_cat_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subcat_id', 'assign_products_subcat_id')->references('id')->on('subcategories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subcat_id', 'assign_products_subcat_id')->references('id')->on('subsections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('supplier_id', 'assign_products_supplier_id')->references('id')->on('subsections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'assign_products_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'assign_products_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'assign_products_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_assign_products');
    }
};
