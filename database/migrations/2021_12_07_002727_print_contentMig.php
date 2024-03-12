<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PrintContentMig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('print_content');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('print_content', function (Blueprint $table) {
            //【目前】仅为加菜的【打印】所用。
            //由于账单已经有一套存储，暂时不知道要不要加到这里。
            $table->id();
            $table->unsignedBigInteger('que_id');
            $table->unsignedTinyInteger('row')->default(0);
            $table->unsignedInteger('dish_id');
            $table->unsignedSmallInteger('number');
            $table->unsignedBigInteger('print_menu_id');
            $table->decimal('price',6,2)->default(0);
            
            $table->foreign('dish_id')->references('id')->on('dish');
            $table->foreign('que_id')->references('id')->on('printer_queue');
            $table->foreign('print_menu_id')->references('id')->on('print_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('print_content');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
