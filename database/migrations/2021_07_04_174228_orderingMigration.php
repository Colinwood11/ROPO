<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class OrderingMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('ordering');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('ordering', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('order_at');
            $table->decimal('price',7,2);
            $table->string('status');
            $table->unsignedTinyInteger('que_number')->default(0);
            $table->string('menu')->nullable()->default(0);
            $table->unsignedInteger('number')->default(1);
            $table->unsignedInteger('dish_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('table_history_id')->nullable();
            $table->timestamps();
            $table->foreign('dish_id')->references('id')->on('dish');//could be truncated?
            $table->foreign('user_id')->references('id')->on('users');//could be truncated?

            $table->foreign('table_history_id')->references('id')->on('table_history');
            //$table->foreign('table')->references('id')->on('table');//could be truncated?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordering');
    }
}
