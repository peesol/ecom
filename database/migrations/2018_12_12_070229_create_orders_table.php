<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->string('title');
          $table->string('uid');
          $table->text('body');
          $table->char('fee', 20)->nullable();
          $table->char('total', 20);
          $table->string('discount')->nullable();
          $table->text('shipping')->nullable();
          $table->string('carrier', 30)->nullable();
          $table->string('tracking_number', 40)->nullable();
          $table->text('address')->nullable();
          $table->string('date_paid', 100)->nullable();
          $table->text('status');
          $table->text('cancle')->nullable();

          $table->timestamps();
          $table->softDeletes();

          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
