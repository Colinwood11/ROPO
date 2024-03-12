<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Variant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('variant');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('variant', function (Blueprint $table) {
            $table->string('dish_variant_name');
            $table->unsignedInteger('dish_id');
            $table->primary(['dish_variant_name','dish_id']);
            $table->foreign('dish_variant_name')->references('name')->on('dish_variant');
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
        Schema::dropIfExists('variant');
    }
}
