<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TableHistoryMig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('table_history');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('table_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_id')->nullable();
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('end_time')->nullable();
            $table->timestamp('last_order')->nullable();
            $table->timestamp('last_merge')->nullable();
            $table->decimal('table_discount',6,2)->default(0);
            $table->unsignedTinyInteger('merge_lock')->default(0);
            $table->timestamp('lock_time')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->unsignedInteger('num_person')->default(1);
            $table->unsignedSmallInteger('order_times')->default(0);
            //$table->primary(['table_id','start_time']);
            $table->foreign('table_id')->references('id')->on('table_res');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_history');
    }
}
