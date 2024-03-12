<?php

use App\Http\Controllers\Api\PrinterCacheC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('')->namespace('Api')->group(/*['namespace'=>'Api'],*/function(){
    Route::prefix('/printer')->group(function(){

        Route::/*middleware('ApiAuth:printer')->*/prefix('')->group(function()
        {
            Route::get('/','PrinterQueueC@GetPrintQueue');
            Route::get('/get/{id}','PrinterQueueC@PrintRequest');
            Route::post('/finish','PrinterQueueC@PrintFinish');
            Route::post('/insert','PrinterQueueC@receive_insert');
            Route::get('/test','PrinterQueueC@testDomPDF');
        });
    });
});

Route::group(['namespace'=>'Api','prefix'=>'apitest'],function(){

        
        Route::prefix('/dish')->group(function(){
            #//获取过滤过的菜
          Route::post('/filtered','DishC@get_all_filtered')->name('ApiFiltered');
        });
        #
        Route::prefix('/table')->group(function(){
            //获取过滤过的菜
#            Route::post('/deactivate','TableC@DeactiveTable');
        });

        Route::get('/mergetable/{table_history_id}','PrinterCacheC@ManualMerge')->name('ApiMergeTableHistory');

        Route::get('/checkmerge','PrinterCacheC@CheckMerge');

        //Route::post('/updateorder','OrderNowC@receive_update')->name('OrderUpdateStaff');

        
});