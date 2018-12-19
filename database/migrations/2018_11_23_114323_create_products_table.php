<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('category_id')->unsigned();
          $table->integer('subcategory_id')->unsigned()->nullable();
          $table->string('uid');
          $table->string('name');
          $table->integer('price');
          $table->integer('discount_price')->nullable();
          $table->text('description')->nullable();
          $table->string('thumbnail');
          $table->text('choice')->nullable();
          $table->integer('view_count')->default(0);
          $table->enum('visibility', ['public', 'unlisted']);
          $table->boolean('available')->default(true);
          $table->integer('stock')->default(1);
          $table->boolean('featured')->default(false);
          $table->timestamps();

          $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
          $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
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
}
