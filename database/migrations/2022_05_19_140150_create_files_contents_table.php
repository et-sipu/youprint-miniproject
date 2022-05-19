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
        Schema::create('files_content', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('file_id');
            $table->integer('UNIQUE_KEY');
            $table->string('PRODUCT_TITLE')->nullable();
            $table->text('PRODUCT_DESCRIPTION')->nullable();
            $table->string('STYLE',10)->nullable();
            $table->string('AVAILABLE_SIZES',50)->nullable();
            $table->string('BRAND_LOGO_IMAGE',100)->nullable();
            $table->string('THUMBNAIL_IMAGE',100)->nullable();
            $table->string('COLOR_SWATCH_IMAGE',100)->nullable();
            $table->string('PRODUCT_IMAGE',100)->nullable();
            $table->string('SPEC_SHEET',100)->nullable();
            $table->string('PRICE_TEXT',100)->nullable();
            $table->string('SUGGESTED_PRICE',20)->nullable();
            $table->string('CATEGORY_NAME',50)->nullable();
            $table->string('SUBCATEGORY_NAME',30)->nullable();
            $table->string('COLOR_NAME',100)->nullable();
            $table->string('COLOR_SQUARE_IMAGE',50)->nullable();
            $table->string('COLOR_PRODUCT_IMAGE')->nullable();
            $table->string('COLOR_PRODUCT_IMAGE_THUMBNAIL')->nullable();
            $table->string('SIZE',10)->nullable();
            $table->integer('QTY')->nullable();
            $table->string('PIECE_WEIGHT',10)->nullable();
            $table->string('PIECE_PRICE',20)->nullable();
            $table->string('DOZENS_PRICE',20)->nullable();
            $table->string('CASE_PRICE',20)->nullable();
            $table->string('PRICE_GROUP',10)->nullable();
            $table->integer('CASE_SIZE')->nullable();
            $table->integer('INVENTORY_KEY')->nullable();
            $table->integer('SIZE_INDEX')->nullable();
            $table->string('SANMAR_MAINFRAME_COLOR',20)->nullable();
            $table->string('MILL',20)->nullable();
            $table->string('PRODUCT_STATUS',30)->nullable();
            $table->string('COMPANION_STYLES')->nullable();
            $table->string('MSRP',10)->nullable();
            $table->string('MAP_PRICING')->nullable();
            $table->text('FRONT_MODEL_IMAGE_URL')->nullable();
            $table->text('BACK_MODEL_IMAGE')->nullable();
            $table->text('FRONT_FLAT_IMAGE')->nullable();
            $table->text('BACK_FLAT_IMAGE')->nullable();
            $table->text('PRODUCT_MEASUREMENTS',40)->nullable();
            $table->string('PMS_COLOR')->nullable();
            $table->string('GTIN')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_content');
    }
};
