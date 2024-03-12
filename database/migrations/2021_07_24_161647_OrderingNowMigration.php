<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class OrderingNowMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('OrderingNow');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('OrderingNow', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('order_at');
            $table->decimal('price',7,2);
            $table->string('status');
            $table->unsignedInteger('menu');
            $table->unsignedInteger('number')->default(1);
            $table->unsignedInteger('dish_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedSmallInteger('que_number')->default(0);
            $table->string('note')->nullable();
            $table->unsignedBigInteger('table_history_id')->nullable();
            $table->timestamps();
            $table->foreign('dish_id')->references('id')->on('dish');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('table_history_id')->references('id')->on('table_history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('OrderingNow');
    }
}
