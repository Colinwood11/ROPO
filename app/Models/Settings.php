<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends GeneralModel{
    
    protected $table = 'settings';
    protected $primaryKey ='name';
    public $incrementing = false;

    protected $fillable = ['name', 'value'];
    public $timestamps = false;

    public static function GetMergeInterval()
    {   
        $settings = self::where('name','merge_delay')->first();
        if(isset($settings))
        {
            $value = $settings->value;
            if(isset($value)){return $value;}
        }
        return 0;
    }
}