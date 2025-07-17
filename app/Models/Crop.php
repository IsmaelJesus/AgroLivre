<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Crop extends Model
{

    protected $fillable = ['name','planting_date','harvest_date','farm_id'];
    protected $casts = [
        'planting_date' => 'date',
        'harvest_date' => 'date',
    ];

    public function farm(): BelongsTo{
        return $this->belongsTo(Farm::class, 'farm_id');
    }

    public function activity() : BelongsTo{
        return $this->belongsTo(Activity::class);
    }
}
