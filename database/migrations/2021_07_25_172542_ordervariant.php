<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Ordervariant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('ordervariant');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('ordervariant', function (Blueprint $table) {
            $table->unsignedBigInteger('ordering_id');
            $table->string('dish_variant_name');
            $table->smallInteger('dose');
            $table->foreign('ordering_id')->references('id')->on('OrderingNow');
            $table->foreign('dish_variant_name')->references('name')->on('dish_variant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordervariant');
    }
}
