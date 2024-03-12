<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SubCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('subcategory');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('subcategory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('Category_id')->nullable();
            $table->integer('weight')->default(0);
            $table->foreign('Category_id')->references('id')->on('category');      
            //$table->primary('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategory');
    }
}
