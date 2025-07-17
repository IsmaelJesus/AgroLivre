<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyAplication extends Model
{
    public function supply(){
        return $this->hasMany(Supply::class, 'id');
    }
}
