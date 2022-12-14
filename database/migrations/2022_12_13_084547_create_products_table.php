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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('subcat_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('warranty')->nullable();
            $table->integer('qty');
            $table->integer('total_price');
            $table->string('img')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('cat_id', 'products_cat')->references('id')->on('asset_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subcat_id', 'products_subcat')->references('id')->on('subcategories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('brand_id', 'products_brand')->references('id')->on('asset_brands')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('unit_id', 'products_unit')->references('id')->on('asset_units')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('department_id', 'products_departmetn')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'products_created')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by', 'products_deleted')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'products_updated')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
