<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Activity extends Model{

    protected $fillable = ['name','type','start_date','finish_date','observations','crop_id','plot_id','farm_id','supply_id','seed_id','diesel_value','supply_estimated_value','user_id'];
    protected $casts = [
        'start_date' => 'date',
        'finish_date' => 'date',
    ];

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function machinery(): BelongsToMany
    {
        return $this->belongsToMany(Machinery::class, 'machinery_use_activity')
                ->withPivot(['id','diesel_consumption']) // adicione aqui os campos extras
                ->withTimestamps();
    }

    public function plot(): BelongsTo
    {
        return $this->belongsTo(Plot::class);
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }

    
    public function supply() : BelongsTo{
        return $this->belongsTo(related: Supply::class);
    }

    public function seed() : BelongsTo{
        return $this->belongsTo(related: Seed::class);
    }
}
