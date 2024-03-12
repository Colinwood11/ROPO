<?php

namespace App\Http\Controllers\Api;

use App\Models\Dish;
use App\Http\Requests\insert\dish_insert;
use App\Http\Requests\update\dish_update;
use App\Http\Requests\delete\dish_delete;
use App\Http\Requests\dish_filter_request;
use App\Models\DishMenu;
use App\Models\Variant;
use App\Models\Type;
use Carbon\Carbon;

class DishC extends ApiController
{
    public function __construct()
    {
        $this->_model = new Dish;
    }

    public function get_all_filtered(dish_filter_request $request)
    {
        if(!isset($request->type))
        {
            return $this->_model->GetAllMenu($request->menu_id);
        }

        return $this->_model->Get_filtered($request->menu_id,$request->type);


    }

    protected function get_all_process(&$collection)
    {
        $collection->each(function($dish)
        {   
            $dish->type->each(function($type)
            {
                if(isset($type->subcategory))
                {
                    $type->name = $type->subcategory->name;
                }
                else
                {
                    $type->name = 'NULL';
                }                

            })->makehidden(['subcategory','subcategory_id','dish_id']);
            
        });
    }

    public function ApiGetAll()
    {
        $data = $this->GetAll()->map(function ($dish) {
            $dish->numbercode = null;
            if(isset($dish->code)){
                $dish->numbercode = $dish->code;
                if(isset($dish->number_code)){
                    $dish->numbercode .= $dish->number_code;
                }
            }
            return collect($dish->toArray())
                ->only(['id', 'name','numbercode','number_code','code'])
                ->all();
        });
        return response($data,200);
    }

    protected function get_key_process(&$collection)
    {
        $collection->type->each(function($type)
        {
            if(isset($type->subcategory))
            {
                $type->name = $type->subcategory->name;
            }
            else
            {
                $type->name = 'NULL';
            }
            //$type->name = $type->subcategory->name;

        })->makehidden(['subcategory','dish_id']);

        $collection->variant->makehidden('dish_id');
        $collection->dish_menu->each(function($menu)
        {
            $menu->name = $menu->menu->name;
            $now = Carbon::now();
            $start = Carbon::parse($menu->start_discount);
            $end = Carbon::parse($menu->end_discount);
            if ($now->between($start, $end) === false) {
                
                $menu->makehidden(['discounted_price','start_discount','end_discount']);
            }
            else{
                //$menu->discount = true;
            }

        })->makehidden(['dish_id','menu']);

    }
    
    

    public function UpdatePreProcess(array &$data)
    {
        if(isset($data['dish_menu']))
        {

            DishMenu::where('dish_id',$data['id'])->delete();
            foreach($data['dish_menu'] as $menu)
            {
                DishMenu::create($menu);
            }
        }
        else
        {
            DishMenu::where('dish_id',$data['id'])->delete();
        }
        unset($data['dish_menu']);
        if(isset($data['type']))
        {
            Type::where('dish_id',$data['id'])->delete();
            Type::insert($data['type']);
        }
        unset($data['type']);
    }

    public function receive_update(dish_update $request)
    {
        return($this->update($request->all()));
    }

    //
    public function receive_insert(dish_insert $request)
    {
        $data = $request->all();
        
        
        if(!isset($data['description']))
        {
            $data['description'] = ' ';
        }

        $model = $this->_model;
        $model->fill($data)->save();
        if(isset($data['dish_menu']))
        {
            $dish_menu_array = $data['dish_menu'];
            foreach($dish_menu_array as &$dish_menu)
            {
                $dish_menu['dish_id'] = $model->id;
                
            }
        }
        DishMenu::insert($dish_menu_array);
        if(isset($data['type']))
        {
            $type_array = $data['type'];
            foreach($type_array as &$dish_type)
            {
                $dish_type['dish_id'] = $model->id;

            }
        }
        
        Type::insert($type_array);

        return ['messagge'=> 'success'];
    }

    public function receive_delete(dish_delete $request)
    {
        $dish = $this->_model->with(['ordering','orderingnow','variant','type','dish_menu'])->find($request->id);
        $dish->deleteRelationship();
        if(count($dish->ordering)>0 || count($dish->orderingnow)>0)
        {
            $dish->status = -1;
            $dish->save();
            $message = 'order detected, hiding instead deleting';
        }
        else
        {
            $dish->delete();
            $message = 'dish has no order, permanent deleted';
            
        }

        return response(['message' => $message],201); 
    }

    protected function InsertpreProcess(array &$data_array)
    {
        if (isset($data_array['menu_array'])) 
        {
            $menu_list = '';
            foreach($data_array['menu_array'] as $menu)
            {
                $menu_list .= $menu.',';
            }
            $data_array['menu_array'] = $menu_list;
        }
    }
    
}
