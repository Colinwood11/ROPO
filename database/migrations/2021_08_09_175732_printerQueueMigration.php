<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PrinterQueueMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('printer_queue');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('printer_queue', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('old')->default(0);
            $table->timestamp('printed_at')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->unsignedSmallInteger('printer')->default(0);//0 cashier 1 kichen 2 sushi
            $table->string('order_ids');
            $table->string('table_number')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('note')->nullable();
            $table->unsignedSmallInteger('status')->default(0); //0 waiting for print, 1 requested ,2 printed with success
            $table->unsignedTinyInteger('type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_queue');
    }
}
