<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintMenu extends Model
{
    use HasFactory;
    protected $table = 'print_menu';
    protected $primaryKey = 'id';

    protected $fillable = ['id','que_id','menu_name','menu_price','number_person'];
    public $timestamps = false;

    public static function GetMenuWithContent(int $que_id)
    {
        $menus = self::where('que_id',$que_id)->get();
        foreach($menus as &$menu){
            $menu->dishes = PrintContent::GetContent($que_id,$menu->id);
        }
        return $menus;
    }

    public function PrintContent()
    {
        return $this->hasMany(PrintContent::class,'print_menu_id');
    }
}
