<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderInvoice;
use App\Models\DishMenu;
use App\Models\Menu;

class OrderInvoiceC extends ApiController
{
    public function __construct()
    {
        $this->_model = new OrderInvoice;
    }
    
    protected function get_key_process(&$data)
    {
        $data = $this->ParseInvoice($data);
    }

    protected function ParseInvoice($invoice)
    {
        $menus = Menu::whereIn('id', collect($invoice->orders->pluck('menu')->unique()))->get();
        $dish_menu = DishMenu::all()->toArray();
        #group by menus
        #$print_menus =  $menus->find(collect($invoice->orders->pluck('menu')->unique()));
        $num_person = $invoice->orders->first()->TableHistory->num_person;
        
        $menus->map(function ($menu) use ($invoice, $dish_menu, $num_person) {

            $menu->dishes = $invoice->orders->where('menu', $menu->id)->map(function ($item) use ($dish_menu) {

                $item->dish = $item->dish->name;
                $item->total_price = $item->price * $item->number;
                return $item->only('id','dish_id','dish', 'number', 'price', 'total_price');
            });
            $menu->menu_total_price = $num_person * $menu->fixed_price + $menu->dishes->sum('total_price');
        });
        
        $invoice->menus = $menus;
        #merge orders of menus
        foreach ($invoice->menus as &$menu)
        {
            $order_merged = array();
            foreach($menu->dishes as $dish_order)
            {   
                $key = $dish_order['dish_id'];
                if(isset($order_merged[$key]))
                {
                    $order_merged[$key]['number'] += $dish_order['number'];
                    $order_merged[$key]['total_price'] += $dish_order['total_price'];
                }
                else
                {
                    $order_merged[$key] = array();
                    $order_merged[$key]['number'] = $dish_order['number'];
                    $order_merged[$key]['total_price'] = $dish_order['total_price'];
                    $order_merged[$key]['price'] = $dish_order['price'];
                    $order_merged[$key]['dish_id'] = $dish_order['dish_id'];
                    $order_merged[$key]['dish'] = $dish_order['dish'];

                }
            }
            $menu->dishes = $order_merged;
            
        }
        $invoice->table_number = $invoice->orders[0]->TableHistory->table->number;
        $invoice->persons = $num_person;
        $invoice->total_dishes = $invoice->orders->sum('number');
        $invoice->total_price = $invoice->menus->sum('menu_total_price');
        OrderInvoice::find($invoice->id)->update(['value'=>$invoice->total_price]);
        //$invoice->orders = array_values($order_merged);
        $invoice->created_at = Carbon::parse($invoice->created_at)->format('y-m-d H:i:s');
        return $invoice;
    }

}
