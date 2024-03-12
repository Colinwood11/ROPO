<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//user1= User lv1 已登录客人
//user2= User lv2 跑堂
//user3= User lv3 收银员
//user4= User lv4 老板

Route::get('/', 'Controller@index');
Route::get('/order', 'OrderController@index')->name('order');

//test routes andthe structure model
//public 
//Route::group(['namespace'=>'Api','middleware' => 'ApiAuth:user2'],function(){
//
//Route::get('/user', 'TableC@get_user');
//
//});
Route::/*middleware('can:waiter')->*/prefix('')->group(function () { //服务员权限




});
Route::get('/code', 'CodeController@ViewCode')->name('CodeView');
Route::get('/cart', 'CartController@ViewCart')->name('CartView');
Route::get('/orderlist', 'OrderController@OrderListView')->name('OrderListView');

Route::middleware('LeoAuth:waiter')->prefix('/admin')->namespace('Admin')->group(function () {

    Route::post('/testUser','AdminController@AdminAjax')->name('testPost');
    #Dish相关的功能
    Route::prefix('')->group(function () {
        Route::get('/dishlist', 'AdminController@View_DishList')->name('DishList');
        Route::get('/adddish', 'AdminController@View_DishForm')->name('AddDishForm');
        Route::get('/dishupdate/{id}', 'AdminController@View_DishFormUpdate')->name('getDishForm');
    });
    Route::get('/', 'AdminController@index')->name('AdminIndex');

    #Order相关的功能
    Route::prefix('')->group(function () {
        Route::get('/orderlist', 'AdminController@View_OrderList')->name('OrderList');
        Route::get('/oldorder', 'AdminController@View_OrderListOld')->name('OrderListOld');
        #Route::post('/confirm','AdminController@StaffConfirm')->name('OrderConfirmStaff');
        Route::get('/invoice/{id}', 'AdminController@View_OrderInvoice')->name('OrderInvoice');
    }); 

    #Table功能
    Route::prefix('')->group(function () {
        Route::get('/tablelist', 'AdminController@View_TableList')->name('TableList');
        Route::get('/table_orders/{id}','AdminController@View_TableOrders')->name('GetTableWithHistory');
        #Route::get('/oldorder', 'AdminController@View_OrderListOld')->name('OrderListOld');
        #Route::post('/confirm','AdminController@StaffConfirm')->name('OrderConfirmStaff');
        Route::get('/table_new_dish','AdminController@View_TableAddDish')->name('TableAddDish');
        
    });
    
    Route::get('/settings', 'AdminController@View_SettingsForm')->name('adminSettings');
    
    Route::get('/categorylist', 'AdminController@View_CategoryList')->name('CategoryList');

    Route::get('/menulist', 'AdminController@View_MenuList')->name('MenuList');
});

#因为暂时没有添加token系统所以只有patch一个【伪api】
Route::group(['namespace'=>'Api','prefix' => '/api'],function(){

    Route::prefix('/dish')->group(function(){

        //Route::post('/json_array','dishC@test_JsonArray');
        //获取列表（所有）
        Route::get('/all','DishC@ApiGetAll')->name('ApiDishAll');
        //获取单个菜的细节
        Route::get('/key/{id}','DishC@get_key')->name('DishKey');
        //获取过滤过的菜
        Route::post('/filtered','DishC@get_all_filtered')->name('DiShFiltered');
        //user level4
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','DishC@receive_insert')->name('ApiDishInsert');

            Route::match(['POST','PUT'],'/update','DishC@receive_update')->name('ApiDishUpdate');

            Route::match(['POST','DELETE'],'/delete','DishC@receive_delete')->name('ApiDishDelete');


        });

    });


    Route::middleware('LeoAuth:waiter')->prefix('/category')->group(function(){

        Route::get('/all','CategoryC@get_all');
        Route::get('/key/{id}','CategoryC@get_key');

        //user level4
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','CategoryC@receive_insert');

            Route::match(['POST','PUT'],'/update','CategoryC@receive_update');

            Route::match(['POST','DELETE'],'/delete','CategoryC@receive_delete');

        });

    });

    Route::middleware('LeoAuth:waiter')->prefix('/dishmenu')->group(function(){

        Route::get('/all','DishMenuC@GetAll')->name('ApiDishMenuAll');
    });

    Route::middleware('LeoAuth:waiter')->prefix('/subcategory')->group(function(){

        Route::get('/all','SubCategoryC@get_all');
        Route::get('/key/{id}','SubCategoryC@get_key');

        //user level4
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','SubCategoryC@receive_insert');

            Route::match(['POST','PUT'],'/update','SubCategoryC@receive_update');

            Route::match(['POST','DELETE'],'/delete','SubCategoryC@receive_delete');

        });

    });



    Route::prefix('/province')->group(function(){

        Route::get('/all','provinceC@get_all');
        Route::get('/key/{id}','provinceC@get_key');

    });

    Route::prefix('/faq')->group(function(){

        Route::get('/all','faqC@get_all');
        Route::get('/key/{id}','faqC@get_key');

        //user4
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()

        {   Route::post('/insert','faqC@receive_insert');
            Route::match(['POST','PUT'],'/update','faqC@receive_update');
            Route::match(['POST','DELETE'],'/delete','faqC@receive_delete');
        });
    });




    Route::prefix('/DishVariant')->group(function(){

        Route::get('/all','DishVariantC@get_all');
        Route::get('/key/{id}','DishVariantC@get_key');

        //user4
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {   
            Route::post('/insert','DishVariantC@receive_insert');
            Route::match(['POST','PUT'],'/update','DishVariantC@receive_update');
            Route::match(['POST','DELETE'],'/delete','DishVariantC@receive_delete');
        });

    });

    Route::prefix('/table_history')->group(function(){

        Route::get('/all','TableHistoryC@get_all');
        Route::get('/key/{id}','TableHistoryC@get_key');
        Route::post('/insert','TableHistoryC@receive_insert');

        //user3
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {   
            //Route::get('/orders','TableHistoryC@receive_delete');
            Route::post('/update','TableHistoryC@receive_update')->name('ApiTableHistoryUpdate');
            Route::post('/merge_lock','TableHistoryC@lock_history')->name('ApiLockHistory');
            Route::post('/merge_unlock','TableHistoryC@unlock_history')->name('ApiUnlockHistory');
        });

        //user4
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {   
            Route::post('/delete','TableHistoryC@receive_delete');
        });

    });

    Route::prefix('/table')->group(function(){

        //guest
        Route::Get('/checkcode','TableC@CheckCode');

        //user2
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {   
            Route::get('/all','TableC@get_all');
           
            Route::get('/key/{id}','TableC@GetKey');
            //Route::get('/free','TableC@GetFreeTables');
            Route::post('/activate','TableC@ActivateTable')->name('TableActivate');
            
            Route::post('/deactivate','TableC@DeactiveTable')->name('TableDeactivate');
            Route::post('/setmenu','TableC@ChangeMenu')->name('TableChangeMenu');
        });
        
        

        //user level4
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','TableC@receive_insert');
            Route::match(['POST','PUT'],'/update','TableC@receive_update');
            Route::match(['POST','DELETE'],'/delete','TableC@receive_delete');
        });

    });


    Route::prefix('/ordering')->group(function(){

        Route::get('/self','OrderingC@get_self');

        Route::post('/insert_guest','OrderNowC@receive_insert')->name('ApiOrderInsertGuest');

        Route::post('/confirm','OrderNowC@confirm_order')->name('OrderConfirmGuest');

        Route::middleware('LeoAuth:waiter')->prefix('/staff')->group(function()
        {
            Route::post('/insert_waiter','OrderNowC@receive_insert')->name('OrderInsertStaff');
            Route::get('/key/{id}','OrderNowC@get_key');
            Route::get('/all','OrderNowC@get_all');
            Route::get('/unfinished','OrderNowC@GetAllUnfinished');
            Route::post('/confirm','OrderNowC@StaffConfirm')->name('OrderConfirmStaff');
        });

        Route::middleware('LeoAuth:cashier')->prefix('')->group(function()
        {
            Route::post('/cash_order','OrderNowC@cash_order')->name('ApiCashOrder');
        });

        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::match(['POST','PUT'],'/update','OrderNowC@receive_update')->name('OrderUpdateStaff');
            Route::match(['POST','DELETE'],'/delete','OrderNowC@receive_delete')->name('OrderDelete');

            Route::match(['POST','PUT'],'/queupdate','OrderQueC@ReceiveUpdate')->name('OrderQueUpdateStaff');
            Route::match(['POST','DELETE'],'/quedelete','OrderQueC@ReceiveDelete')->name('OrderQueDelete');
        });

    });


    Route::prefix('/address')->group(function(){


        Route::get('/self','AddressC@get_self');

        Route::post('/insert','AddressC@receive_insert');

        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::get('/key/{id}','AddressC@get_key');
            Route::get('/all','AddressC@get_all');

            Route::match(['POST','PUT'],'/update','AddressC@receive_update');
            Route::match(['POST','DELETE'],'/delete','AddressC@receive_delete');
        });

    });

    Route::prefix('/namelang')->group(function(){

        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','NameLangC@receive_insert');
            Route::get('/key/{id}','NameLangC@get_key');
            Route::get('/all','NameLangC@get_all');

            Route::match(['POST','PUT'],'/update','NameLangC@receive_update');
            Route::match(['POST','DELETE'],'/delete','NameLangC@receive_delete');
        });

    });

    Route::prefix('/menu')->group(function(){

        Route::get('/all','MenuC@GetAllMenuApi')->name('ApiAllMenu');
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','MenuC@receive_insert')->name('MenuInsert');
            Route::get('/key/{id}','MenuC@get_key');

            Route::match(['POST','PUT'],'/update','MenuC@receive_update')->name('MenuUpdate');
            Route::match(['POST','DELETE'],'/delete','MenuC@receive_delete')->name('MenuDelete');
        });

    });

    Route::prefix('/langvar')->group(function(){

        
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','langvarC@receive_insert');
            Route::get('/key/{id}','langvarC@get_key');
            Route::get('/all','langvarC@get_all');

            Route::match(['POST','PUT'],'/update','langvarC@receive_update');
            Route::match(['POST','DELETE'],'/delete','langvarC@receive_delete');
        });

    });

    Route::prefix('/settings')->group(function(){

        
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','settingsC@receive_insert');
            Route::get('/key/{id}','settingsC@get_key');
            Route::get('/all','settingsC@get_all');

            Route::match(['POST','PUT'],'/update','settingsC@receive_update')->name('SettingsUpdate');
            Route::match(['POST','DELETE'],'/delete','settingsC@receive_delete');
        });

    });

    Route::prefix('/type')->group(function(){

        
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','TypeC@receive_insert');
            Route::get('/all','TypeC@get_all');

            Route::match(['POST','PUT'],'/update','TypeC@receive_update');
            Route::match(['POST','DELETE'],'/delete','TypeC@receive_delete');
        });

    });

    Route::prefix('/variant')->group(function(){

        
        Route::middleware('LeoAuth:waiter')->prefix('')->group(function()
        {
            Route::post('/insert','VariantC@receive_insert');
            Route::get('/all','VariantC@get_all');

            Route::match(['POST','PUT'],'/update','VariantC@receive_update');
            Route::match(['POST','DELETE'],'/delete','VariantC@receive_delete');
        });

    });

    Route::get('/checkmerge','PrinterCacheC@CheckMerge');
    //Route::prefix('/locale')->group(function(){
    //
    //    
    //    Route::get('/get','ApiController@test_locale');
    //
    //
    //});
});


