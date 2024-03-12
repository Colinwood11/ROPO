<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DishMenuMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('dish_menu');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('dish_menu', function (Blueprint $table) {
            $table->unsignedInteger('dish_id');
            $table->unsignedInteger('menu_id');
            $table->decimal('price',6,2)->default(0);
            $table->decimal('discounted_price')->nullable();
            $table->timestamp('start_discount')->nullable();
            $table->timestamp('end_discount')->nullable();
            $table->tinyInteger('limit')->nullable();
            $table->unique(['dish_id','menu_id']);
            $table->foreign('dish_id')->references('id')->on('dish');
            $table->foreign('menu_id')->references('id')->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dish_menu');
    }
}
