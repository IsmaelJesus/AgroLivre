<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Machinery extends Model
{
    protected $table = 'machinery';
    protected $fillable = ['name','type','brand','model','acquisition_date','hours_use','acquisition_value','useful_life','status','farm_id'];
    protected $casts = [
        'acquisition_date' => 'date',
    ];

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

    public function activities(){
        return $this->belongsToMany(Activity::class, 'machinery_use_activity')
                    ->withPivot(['id','diesel_consumption'])
                    ->withTimestamps();
    }
}
