<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PrinterUpdateMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('printer_update');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('printer_update', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('printer_que_id');
            $table->string('attribute');//dish,number,table_history
            $table->string('new_value');
            $table->foreign('printer_que_id')->references('id')->on('printer_queue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_update');
    }
}
