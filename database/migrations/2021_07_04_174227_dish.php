<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

class Dish extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('dish');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('dish', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_chn')->nullable();
            $table->smallInteger('printer');
            $table->string('status');
            $table->string('img');
            $table->text('description')->nullable();
            $table->string('code')->nullable();
            $table->unsignedSmallInteger('number_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dish');
    }
}
