<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\TableHistory;
use App\Http\Requests\checkcode;
use App\Http\Requests\OpenTableRequest;
use App\Http\Requests\CloseTableRequest;
use App\Http\Requests\insert\table_insert;
use App\Http\Requests\update\TableChangeMenuRequest;
use App\Models\Menu;
use App\Models\OrderingNow;
use App\Models\OrderInvoice;
use App\Models\OrderQue;
use App\Models\OrderUpdate;
use App\Models\PrintContent;
use App\Models\PrinterQueue;
use App\Models\PrinterCache;
use App\Models\PrinterUpdate;
use App\Models\PrinterUpdateContent;
use App\Models\PrintMenu;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
//
class TableC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new Table;
    }

   public function ActivateTable(OpenTableRequest $request)
   {
       //dd($request->all());
       $this->_model = Table::find($request->id);
       if($this->_model->status == '1')
       {
            return response(['message' => 'tavolo e\' gia\' aperto' ],400);
       }
       $person = $request->num_person;
       TableHistory::create(['table_id'=>$this->_model->id,'num_person'=>$person,'created_at'=>Carbon::now(),'start_time'=>Carbon::now(),'end_time'=>NULL]);
       $code = $this->_model->activate();
       return response(['code' => $code],201);
   }

   public function DeactiveTable(CloseTableRequest $request)
   {
        $table = $this->_model->GetWithUnfinishedHistory($request->id);
        $history = $table->TableHistory->first();
        if(isset($history))
        {
            $history->end_time = Carbon::now();
            #删除此桌子所有正在进行中的订单
            OrderingNow::where('table_history_id',$history->id)->delete();
            #删除此桌子还没有打印的账单
            $invoice_prints = PrinterQueue::where('table_number',$table->number)->where('type',1)->whereIn('status',[0,1])->get();
            foreach($invoice_prints as $invoice_print){
                OrderInvoice::where('id',$invoice_print->order_ids)->delete();
            }

            #删除此桌子未完成的队列
            $queue = PrinterQueue::with(['PrinterUpdate'])->where('table_number',$table->number)->whereIn('status',[0,1])->get();
            $queue_ids = $queue->pluck('id');
            PrinterUpdate::whereIn('printer_que_id',$queue_ids)->delete();
            PrintContent::whereIn('que_id',$queue_ids)->delete();
            PrintMenu::whereIn('que_id',$queue_ids)->delete();
            //PrinterUpdate::whereIn('printer_que_id',$queue_ids)->delete(); //Legacy Update Table
            PrinterUpdateContent::whereIn('que_id',$queue_ids)->delete(); //new Upate Table

            PrinterQueue::where('table_number',$table->number)->whereIn('status',[0,1])->delete();
            

            #删除此桌子未打印队列
            OrderQue::where('table_history_id',$history->id)->delete();
            PrinterCache::where('table_number',$table->number)->delete();


            #重新同步两个表的increment数值
            $sql_str = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".env("DB_DATABASE")."' AND TABLE_NAME = 'OrderingNow'";
            $increment_result =  DB::select($sql_str);
            $sql_str1 = "ALTER TABLE ordering AUTO_INCREMENT=".$increment_result[0]->AUTO_INCREMENT."";
            DB::statement($sql_str1);
            
        }
        $table->Deactivate();
        return response(['message'=>'table closed successfully'],200);
   }

   public function ChangeMenu(TableChangeMenuRequest $request)
   {
       $table = $this->_model->find($request->id);
       $table->menu_id = $request->menu_id;
       $table->save();
       return response(['message'=>'tablemenu changed successfully'],200);
   }

    public function CheckCode(checkcode $request)
    {   
        $table = $this->_model->getByCode($request->code);
        if ($table !== null) {
            return response($table,200)->header('Content-Type', 'application/json');
        }
        else
        {
            return response(['message' => 'table not found'],404);
        }
       
    }
    
    //public function get_user(Request $request)
    //{   
    //    //dump($request->user());
    //    //dump(auth()->user());
    //    //dump($request);
    //    //return auth()->user();
    //}

    public function GetKeyHistory($id)
    {
        $table = $this->_model->GetWithUnfinishedHistory($id);

        if(count($table->TableHistory) ==0)
        {
            #return redirect()->route('TableList');
            return $table;
        }

        $table->order_allprice = $table->TableHistory[0]->OrderingNow->sum(function($order)
        {
            return $order->price * $order->number;
        });
        $que_menus = $table->TableHistory[0]->Orderque->pluck('menu')->unique();
        $ordernow_menus = $table->TableHistory[0]->OrderingNow->pluck('menu')->unique();
        $menus = $que_menus->merge($ordernow_menus)->unique();
        $table->menus = Menu::whereIn('id',$menus)->get();
        $table->menu_allprice = $table->menus->sum('fixed_price')*$table->TableHistory[0]->num_person;
        $table->order_stacked = $this->OrderNowProcessing($table->TableHistory[0]->OrderingNow);
        return $table;
    }

    protected function OrderNowProcessing($OrderignNow)
    {
        $orderstack = array();
        $menus = Menu::all();
        $id = 0;
        foreach($OrderignNow as $order)
        {
            $key = '';
            $key = $order->dish_id.$order->menu;
            if(isset($orderstack[$key]))
            {
                $orderstack[$key]['number'] = $orderstack[$key]['number'] + $order->number;
                $orderstack[$key]['total_price'] = $orderstack[$key]['total_price'] + $order->number*$order->price;
                $orderstack[$key]['orders'][] = $order;
                $orderstack[$key]['count']++;
            }
            else
            {
                $orderstack[$key] = array();
                $orderstack[$key]['dish'] = $order->dish->name;
                $orderstack[$key]['menu'] = $menus->find($order->menu)->name;
                $orderstack[$key]['number'] = $order->number;
                $orderstack[$key]['total_price'] = $order->number*$order->price;
                $orderstack[$key]['orders'][] = $order;
                $orderstack[$key]['count'] = 1;
                $orderstack[$key]['id']=$id;
                $id++;
                
            }
        }

        return array_values($orderstack);
    }

    protected function ParseCheckmergeTimer(&$tableHistory)
    {
        $cache_model = (new PrinterCacheC);
        $last_merge = Carbon::parse($tableHistory->last_merge);
        $person_minutes_ago = Carbon::now()->subMinutes($tableHistory->num_person);
        $next_checkmerge = $last_merge->addMinutes($tableHistory->num_person);
        $next_order = Carbon::parse($tableHistory->last_order)->addMinutes($cache_model->MergeAdditionalWait);

        #如果merge长时钟还没有到，会有以下两种情况
        #1：最后订单的等待时间（小时钟）超过了merge大时钟
        #2：最后订单的等待时间（小时钟）没有超过merge大时钟
        if($person_minutes_ago < $last_merge)
        {   
            if($next_checkmerge < $next_order)
            {
                $tableHistory->next_checkmerge = $next_order->format('H:i:s');
            }
            else
            {
                $tableHistory->next_checkmerge = $next_checkmerge->format('H:i:s');
            }
            
        }
        #如果merge长时钟已经到期，但是merge还没有执行，则只有一种可能：
        #1最后订单的小时钟超过了merge大时钟
        else
        {
            $tableHistory->next_checkmerge = $next_order->format('H:i:s');
        }
    }

    public function GetKeyHistoryNotPrinted($id)
    {
        $table = $this->_model->GetWithUnfinishedHistoryNotPrinted($id);
        
        if(!isset($table->TableHistory) || count($table->TableHistory) ==0)
        {
            #return redirect()->route('TableList');
            return $table;
        }


        $this->ParseCheckmergeTimer($table->TableHistory[0]);

        $table->order_allprice = $table->TableHistory[0]->Orderque->sum(function($order)
        {
            return $order->price * $order->number;
        });
        return $table;
    }

    public function GetAllUnfinished()
    {
        $table = $this->_model->GetAllUnfinished();
        return $table;
    }

    public function receive_insert(table_insert $request)
    {
        return $this->insert($request->all());
    }

    protected function get_all_process(&$collection)
    {
        
    }


    protected function get_key_process(&$collection)
    {
        
    }

    protected function preProcess(array &$data_array)
    {
       
    }

    protected function postProcess(array &$data_array)
    {
       
    }
}
