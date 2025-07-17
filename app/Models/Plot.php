<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Plot extends Model
{
    protected $fillable = ['name','area','farm_id'];

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
            'farm_id',       // foreign key em Plot
            'user_id'        // foreign key em Farm
        );
    }
}
