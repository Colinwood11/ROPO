<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends GeneralModel{
    
    protected $table = 'address';
    protected $primaryKey ='address_id';

    protected $fillable = ['name', 'surname','via','number','city','province','region','phone','user_id'];
    public $timestamps = false;

    public function get_self($user_id)
    {
        
        if (isset($user_id)) {
            return($user_id);
            return $this->where('user_id',$user_id)->get();
        }

        return null;
        
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}