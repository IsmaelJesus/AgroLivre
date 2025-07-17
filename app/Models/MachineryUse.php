<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MachineryUse extends Model
{
    public function machinery(): HasMany{
        return $this->hasMany(Machinery::class, 'id');
    }
}
