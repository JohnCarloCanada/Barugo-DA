<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeedIssuanceHistory extends Model
{
    use HasFactory;


    protected $fillable = [
        'season_id',
        'area_id',
        'Seed_Variety',
        'Quantity',
    ];

    public function season(): BelongsTo {
        return $this->belongsTo(Season::class, 'season_id', 'id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

}
