<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Type extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('type');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('type', function (Blueprint $table) {
            $table->unsignedInteger('subcategory_id');
            $table->unsignedInteger('dish_id');
            $table->primary(['subcategory_id','dish_id']);
            $table->foreign('subcategory_id')->references('id')->on('subcategory');
            $table->foreign('dish_id')->references('id')->on('dish');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type');
    }
}
