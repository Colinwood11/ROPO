<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Orderqueing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('Orderque');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('Orderque', function (Blueprint $table) {        
            $table->bigIncrements('id');
            $table->timestamps();
            $table->decimal('price',7,2);
            $table->string('status');
            $table->unsignedInteger('menu');
            $table->unsignedInteger('number')->default(1);
            $table->string('note')->nullable();
            $table->unsignedInteger('dish_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('cache_id')->nullable();
            $table->unsignedBigInteger('table_history_id')->nullable();
            $table->foreign('dish_id')->references('id')->on('dish');//could be truncated?
            $table->foreign('user_id')->references('id')->on('users');//could be truncated?
            $table->foreign('table_history_id')->references('id')->on('table_history');
            $table->foreign('cache_id')->references('id')->on('printer_cache');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Orderque');
    }
}
