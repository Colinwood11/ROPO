<?php

namespace App\Models;

use App\Http\Requests\insert\printer_insert;
use App\Models\PrinterUpdate;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PrinterCache extends GeneralModel
{
    protected $table = 'printer_cache';
    protected $primaryKey = 'id';

    protected $fillable = ['printer', 'order_ids', 'table_number', 'note', 'created_at', 'cluster_id'];
    public $timestamps = false;

    public static function Merge($printer, $table_number, $ids = null)
    {
        $caches = self::where('printer', $printer)->where('table_number', $table_number)->get();
        $first = $caches->first();
        $cache_ids = $caches->pluck('id');
        $printer_data_global['table_number'] = $first->table_number;
        $printer_data_global['status'] = 3; //status 3用来防止打印机通过api抢线程。
        $printer_data_global['type'] = 0;
        $printer_data_global['printer'] = $printer;
        $printer_data  = [];

        foreach ($printer_data_global as $key => $value) {
            $printer_data[$key] = $value;
        }
        $printer_data['order_ids'] = '';
        $OrderQueues = OrderQue::whereIn('cache_id', $cache_ids)->get();
        $orderMenus = $OrderQueues->pluck('menu')->unique();
        $OrderQueues = $OrderQueues->toArray();
        $menus = Menu::whereIn('id', $orderMenus)->get()->keyBy('id');
        if (count($OrderQueues) > 0) {

            $table_history_id = isset($OrderQueues[0]) ? $OrderQueues[0]['table_history_id'] : $OrderQueues['table_history_id'];

            $orderNow = OrderingNow::where('table_history_id', $table_history_id)->get();
            $orderNow_Indexed = [];

            //因为用哈希表能够更快的进行查找与合并。
            foreach ($orderNow as $order) {
                $key = 'dish' . $order->dish_id . $order->menu;
                $orderNow_Indexed[$key] = $order;
            }

            $order = $OrderQueues[0];
            //合并orderque
            $order_processed = self::array_processing($OrderQueues, $order['table_history_id']);
            $printer_que = PrinterQueue::create($printer_data);
            $PrintMenus = [];
            foreach ($menus as $menu) {
                $tmp = [];
                $tmp['que_id'] = $printer_que->id;
                $tmp['menu_price'] = $menu->fixed_price;
                $tmp['menu_name'] = $menu->name;
                $tmp['number_person'] = TableHistory::find($order['table_history_id'])->num_person;
                //TODO:移动到外面一次性获取所有ids
                $newMenu = PrintMenu::create($tmp);
                //字典快速查找模式，因为同一个打印列表里menu不会重复，所以可以使用这种方式。
                $PrintMenus[$menu->id] = $newMenu;
            }


            //合并OrderNow，并添加一个独立于OrderNow的打印内容。
            //这种情况下，打印的内容就不会取决于OrderNow或者Orderque的内容了。
            //因为dish表极少改动，不会有抢线程和数据对不上的问题，所以可以从dish表获取内容，
            $PrintContent = [];
            foreach ($order_processed as $key => $order) {

                #TODO: Bulk update and insert
                if (isset($orderNow_Indexed[$key])) {
                    $orderNow_Indexed[$key]->number += $order['number'];
                    $orderNow_Indexed[$key]->save();
                } else {
                    OrderingNow::create($order);
                }

                //因为打印部分和合并没有关系，所以可以独立出来。
                //PrintContent填表需求内容：'que_id','row','dish_id','number','print_menu_id','price'
                $price = $PrintMenus[$order['menu']]->fixed_price;
                if (!$price) {
                    $price = 0;
                }

                $PrintContent[] = [
                    'que_id' => $printer_que->id,
                    'dish_id' => $order['dish_id'],
                    'number' => $order['number'],
                    'print_menu_id' => $PrintMenus[$order['menu']]->id,
                    'price' => isset($PrintMenus[$order['menu']]->fixed_price)
                ];
            }

            //获取方式Printerqueue->printMenu->printcontent
            PrintContent::insert($PrintContent);
            //状态改为可以获取。
            $printer_que->status = 0;
            $printer_que->save();
        }

        OrderQue::whereIn('cache_id', $cache_ids)->delete();
        $caches = self::where('printer', $printer)->where('table_number', $table_number)->delete();
    }


    public static function ManualMerge($table_number)
    {
        $cache = self::where('table_number', $table_number)->get()->unique('printer')->pluck('printer');
        foreach ($cache as $printer) {
            self::Merge($printer, $table_number);
        }
    }

    #counting the number of dish, assigning the price
    protected static function array_processing($data_array, $table_history_id)
    {

        $merged_data = array();
        $note_row = 0;
        foreach ($data_array as $pos => $dish) {
            if (isset($dish['note'])) {
                $key = 'note' . $note_row;
                $note_row++;
            } else {
                $key = 'dish' . $dish['dish_id'] . $dish['menu'];
            }

            if (isset($merged_data[$key])) {
                $merged_data[$key]['number'] += $dish['number'];
            } else {
                $attributes = ['order_at', 'price', 'status', 'menu', 'number', 'dish_id', 'user_id', 'table_history_id'];
                $merged_data[$key] = array();
                foreach ($attributes as $a)
                    $merged_data[$key][$a] = $dish[$a];
            }
        }
        return $merged_data;
    }


    public static function GetOrders($ids)
    {
        $order_ids_array = explode(",", $ids);
        $orders = OrderQue::wherein('id', $order_ids_array)->get();
        return $orders;
    }

    public static function getMaxCluster()
    {
        return self::max('cluster_id');
    }

    public static function GetOrderTimes($table_number)
    {
        $cache = self::where('table_number', $table_number)->get()->unique('cluster_id');
        return count($cache);
    }

    public function OrderQue()
    {
        return $this->hasMany(OrderQue::class, 'cache_id', 'id');
    }
}
