<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Address extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('address');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        
        Schema::create('address', function (Blueprint $table) {
            $table->bigIncrements('address_id');
            $table->string('region');
            $table->string('city');
            $table->string('province');
            $table->text('via');
            $table->unsignedinteger('number')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('surname');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
