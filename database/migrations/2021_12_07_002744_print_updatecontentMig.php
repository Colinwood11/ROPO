<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PrintUpdateContentMig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('print_update_content');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        //仅为修改删除专用。
        Schema::create('print_update_content', function (Blueprint $table) {
            $table->id();
            //因为需要保留打印的历史内容，所以在获取之后需要保留一份冗余数据所以历史。
            $table->unsignedBigInteger('que_id');

            $table->string('attribute');//dish:菜，number:数量，menu:菜单/套餐，table:桌子。
            $table->string('dish_name')->nullable();
            $table->string('dish_name_chn')->nullable();
            $table->string('original_value')->nullable();
            $table->string('original_value_chn')->nullable();
            $table->smallInteger('type')->default(0);//-1:移除菜,0: 更改数值,1:加菜
            $table->string('target_value')->nullable();
            $table->string('target_value_chn')->nullable();
            $table->unsignedSmallInteger('row')->default(0);          
                       
            $table->foreign('que_id')->references('id')->on('printer_queue');
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
        Schema::dropIfExists('print_update_content');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
