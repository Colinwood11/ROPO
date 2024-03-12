<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends GeneralModel{
    
    protected $table = 'user';
    protected $primaryKey ='id';

    protected $fillable = ['username', 'email','birthday','last_login','role','password','statuts'];
    public $timestamps = true;
    
    public function ordering()
    {
        return $this->hasMany(Ordering::class,'user_id');
    }

    public function adress()
    {
        return $this->hasMany(Adress::class,'user_id');
    }

}