<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\delete\menu_delete;
use App\Http\Requests\insert\menu_insert;
use App\Http\Requests\update\menu_update;
use App\Models\Dish;
use App\Models\DishMenu;
use App\Models\Menu;

class MenuC extends ApiController
{

    public function __construct()
    {
        $this->_model = new Menu;
    }

    protected function get_all_process(&$collection)
    {
        $collection = $collection->filter(function ($item) {
            return $item->status === 1;
        })->sortBy('weight');
    }

    public function GetAllMenuApi()
    {
        $data = $this->GetAll();

        return response($data);
    }

    public function GetAllWithDish($Dish)
    {
        $collection = $this->_model->GetAllWithDish($Dish)->sortBy('weight');
        $collection->each(function (&$item) {
            $item->HasDish = $item->dish_menu->count();
            if ($item->HasDish > 0) {
                if (!($item->dish_menu[0]->discounted_price == NULL && $item->dish_menu[0]->start_discount == NULL && $item->dish_menu[0]->end_discount == NULL)) {
                    $item->discount = true;
                }
            }
        });
        return $collection;
    }

    public function receive_insert(menu_insert $request)
    {
        return $this->insert($request->all());
    }

    public function receive_update(menu_update $request)
    {
        $data = $request->all();
        $duplicate = $this->_model->where('id','!=',$data['id'])->where('name',$data['name'])->get();
        if(count($duplicate)>0)
        {
            return response('il nome non è univoco',400);
        }
        return $this->update($data);
    }

    public function receive_delete(menu_delete $request)
    {
        $model = new DishMenu();
        $model->deleteMenu($request->id);
        return $this->delete($request->all());
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
