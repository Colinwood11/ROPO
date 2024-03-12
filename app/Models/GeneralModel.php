<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralModel extends Model{

    public function get_all()
    {
        return $this->all();
    }

    public function get_key($key)
    {
        return $this->find($key);
    }
}