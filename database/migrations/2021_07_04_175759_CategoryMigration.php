<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CategoryMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('category');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Catname');
            $table->unsignedTinyInteger('weight')->nullable();
            $table->unique('Catname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
