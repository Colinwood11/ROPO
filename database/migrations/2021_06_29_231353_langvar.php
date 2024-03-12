<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Langvar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('langvar');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('langvar', function (Blueprint $table)
         {
            $table->string('name');
            $table->string('lang');
            $table->string('value');
            $table->primary(['name','lang']);
            $table->foreign('name')->references('name')->on('namelang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
