<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PrintMenuMig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('print_menu');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('print_menu', function (Blueprint $table) {
            //因为排版要求先根据menu排版，然后再列出订单，所以这个只是用来【方便】排版和记账，【非必须】。
            $table->id();
            $table->unsignedBigInteger('que_id');
            $table->string('menu_name');
            $table->decimal('menu_price',8,2)->default(0);
            $table->unsignedSmallInteger('number_person')->default(0);
            
            $table->foreign('que_id')->references('id')->on('printer_queue');
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
        Schema::dropIfExists('print_menu');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
