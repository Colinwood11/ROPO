<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Namelang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('namelang');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('namelang', function (Blueprint $table)
         {
            $table->string('name');
            $table->primary('name');
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
        Schema::dropIfExists('namelang');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
