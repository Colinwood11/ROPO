<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('table_res');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('table_res', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique();
            $table->string('num_person')->default(4);
            $table->string('status');
            $table->string('code')->nullable()->unique();
            $table->unsignedInteger('menu_id')->nullable();
            //$table->timestamps();
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
        Schema::dropIfExists('table_res');
    }
}
