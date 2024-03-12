<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\CategoryC;
use App\Http\Controllers\Api\SubCategoryC;
use App\Http\Controllers\Api\SettingsC;
use App\Http\Controllers\Api\DishC;
use App\Http\Controllers\Api\MenuC;
use App\Http\Controllers\Api\OrderingC;
use App\Http\Controllers\Api\OrderInvoiceC;
use App\Http\Controllers\Api\OrderNowC;
use App\Http\Controllers\Api\TableC;
use App\Http\Controllers\Api\TableHistoryC;
use App\Models\Category;
use App\Models\OrderingNow;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\TableHistory;
use App\Http\Requests\update\order_confirm_staff;
use App\Models\order_status;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function index(Request $request)
    {
        $data['tittle'] = __('messages.Home');
        $data['sidebar_active'] = 1;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 1;
        #dd(Auth::user());

        return view('admin.index', $data);
    }



    public function AdminAjax(Request $request)
    {
        return Auth::user();
    }

    public function View_MenuList()
    {
        $data['tittle'] = __('messages.TableList');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['menus'] = (new MenuC)->GetAll()->KeyBy('id')->toArray();
        return view('admin.MenuList ', $data);
    }

    public function View_OrderInvoice($id)
    {
        $data['tittle'] = __('messages.TableList');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        //$data['table'] = (new TableC)->GetKey($id)->toArray();
        $data['menus'] = (new MenuC)->GetAll()->toArray();
        $data['dishes'] = (new DishC)->GetAll()->keyBy('id')->toArray();
        $data['histories'] = (new TableHistory)->GetAllUnfinished()->toArray();
        $data['orders'] = (new OrderInvoiceC)->GetKey($id);
        //dd($data['orders']);
        //var_dump($data);
        return view('admin.OrderInvoice ', $data);

    }

    public function View_TableAddDish()
    {
        $data['tittle'] = __('messages.TableList');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        //$data['table'] = (new TableC)->GetKey($id)->toArray();
        $data['menus'] = (new MenuC)->GetAll()->toArray();
        $data['dishes'] = (new DishC)->GetAll()->keyBy('id')->toArray();
        $data['histories'] = (new TableHistory)->GetAllUnfinished()->toArray();
        $data['order_status'] = OrderStatus::all()->toArray();
        //var_dump($data);
        return view('admin.TableAddDish ', $data);

    }
    public function View_TableList()
    {
        $data['tittle'] = __('messages.TableList');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        #$data['settings'] = (new SettingsC)->get_all();
        
        $data['tables'] = (new TableC)->GetAllUnfinished()->toArray();
        //dd($data['tables']);
        //var_dump($data['tables']);
        return view('admin.TableList', $data);
    }

    public function View_TableOrders($id)
    {
        $data['tittle'] = __('messages.TableList');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['orders'] = (new TableC)->GetKeyHistory($id)->toArray();
        if(count($data['orders']['table_history']) ==0)
        {
            return redirect()->route('TableList');
        }

        $data['ordersque'] = (new TableC)->GetKeyHistoryNotPrinted($id)->toArray();
        $data['order_status'] = OrderStatus::all()->toArray();
        $data['menus'] = (new MenuC)->GetAll()->keyBy('id')->toArray();
        $data['dishes'] = (new DishC)->GetAll()->keyBy('id')->toArray();
        $data['histories'] = (new TableHistoryC)->GetAllUnfinished()->toArray();
        $data['cats'] = (new Category)->get_all()->toarray();
        
        return view('admin.TableOrders.TableOrders', $data);
    }

    public function View_DishList()
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        #$data['settings'] = (new SettingsC)->get_all();
        
        $data['dishes'] = (new DishC)->GetAll()->keyBy('id')->toArray();
        //dd($data['dish']);
        return view('admin.DishList', $data);
    }


    public function View_DishForm()
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['menus'] = (new MenuC)->GetAll()->toArray();
        $data['cats'] = (new CategoryC)->GetAll()->toarray();
        //$data['dish'] = (new DishC)->get_key($id)->toArray();
        //dd($data['dish']);
        
        return view('admin.DishForm', $data);
    }

    public function View_DishFormUpdate($id)
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['dish'] = (new DishC)->GetKey($id)->toArray();
        //dd($data['dish'] );
        $data['menus'] = (new MenuC)->GetAllWithDish($id)->toArray();
        $data['cats'] = (new CategoryC)->GetAll()->toarray();
        #dump($data['dish']);
        #dd($data['cats']);
        $data['update'] = 1;
        #dd($data['menus']);
        return view('admin.DishForm', $data);
    }

    public function View_SettingsForm()
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['settings'] = (new SettingsC)->GetAll()->keyBy('name');
        $data['settings_name'] = $data['settings']->pluck('name');
        //$data['dish'] = (new DishC)->get_key($id)->toArray();
        //dd($data['dish']);
        return view('admin.SettingsForm', $data);
    }

    public function View_OrderList()
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        //$data['settings'] = (new SettingsC)->get_all();
        $data['orders'] = (new OrderNowC)->GetAllUnfinished()->toArray();
        $data['dishes'] = (new DishC)->GetAll()->keyBy('id')->toArray();
        $data['menus'] = (new MenuC)->GetAll()->toArray();
        $data['histories'] = (new TableHistory)->GetAllUnfinished()->toArray();
        #$data['tables'] = (new TableC)->GetAllUnfinished()->toArray();
        //dd($data['menus']);
        
        //dd($data['orders']);
        return view('admin.OrderList', $data);
    }

    public function View_OrderListOld()
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        //$data['settings'] = (new SettingsC)->get_all();
        $data['orders'] = (new OrderingC)->GetAll()->toArray();
        $data['menus'] = (new MenuC)->GetAll()->toArray();
        //dd($data['menus']);
        $data['histories'] = (new TableHistory)->GetAllUnfinished()->toArray();
        //dd($data['histories']);
        return view('admin.OrderListOld', $data);
    }

    public function View_CategoryList()
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        //$data['settings'] = (new SettingsC)->get_all();
        
        $data['categories'] = (new CategoryC)->GetAllOnlyCat()->toArray();
        
        $data['sub_categories'] = (new SubCategoryC)->GetAllWithCategory()->toArray();
        //dd($data['categories']);    
        //var_dump($data['categories']);
        return view('admin.category.main', $data);
    }


    public function StaffConfirm(order_confirm_staff $request)
    {
        (new OrderingNow)->ConfirmOrder($request->id,$request->que_number);
        return ['messagge' => 'success'];
    }


}
