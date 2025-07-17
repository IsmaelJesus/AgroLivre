<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seed extends Supply
{
    protected $table = 'seeds'; // Importante!

    protected $fillable = ['name','type','initial_stock_quantity','measure_unity','value','farm_id','cultivar', 'pms', 'germination', 'vigor'];

    public function activity() : BelongsTo{
        return $this->belongsTo(Activity::class);
    }

}