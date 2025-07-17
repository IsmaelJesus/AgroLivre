<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Supply extends Model
{
    protected $fillable = ['name','type','initial_stock_quantity','measure_unity','value','farm_id'];

    public function farm(): BelongsTo{
        return $this->belongsTo(Farm::class);
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,     // Modelo final (User)
            Farm::class,     // Modelo intermediário (Farm)
            'id',            // chave primária em Farm
            'id',            // chave primária em User
            'farm_id',       // foreign key em Supply
            'user_id'        // foreign key em Farm
        );
    }

    public function activity() : BelongsTo{
        return $this->belongsTo(Activity::class);
    }
}
