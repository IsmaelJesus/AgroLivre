<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farm extends Model
{
    protected $fillable = ['name','location','owner_id'];

    public function users(): BelongsToMany {
    return $this->belongsToMany(User::class)
                ->withPivot('role')
                ->withTimestamps();
    }

    public function plots(): HasMany{
        return $this->hasMany(Plot::class);
    }

    public function supplies(): HasMany{
        return $this->hasMany(Supply::class);
    }
    
    public function machinery(): HasMany{
        return $this->hasMany(Machinery::class);
    }

    public function acitivity(): BelongsTo{
        return $this->belongsTo(Activity::class);
    }
}
