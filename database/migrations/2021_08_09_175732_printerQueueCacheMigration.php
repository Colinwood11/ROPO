<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class printerQueueCacheMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('printer_cache');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('printer_cache', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedSmallInteger('printer')->default(0);//0 cashier 1 kichen 2 sushi
            $table->string('order_ids',8196);
            $table->string('table_number')->nullable();
            $table->unsignedBigInteger('cluster_id')->default(0);
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_cache');
    }
}
