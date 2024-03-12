<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InvoiceMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('order_invoice');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        
        Schema::create('order_invoice', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();;
            $table->longText('order_ids');
            $table->decimal('value',10,2,true)->default(0);
            $table->unsignedTinyInteger('old')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_invoice');
    }
}
