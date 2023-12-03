<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Season',
        'Quantity_of_Seeds',
        'Year',
        'Status'
    ];

    public function checkIfRecordExists($year, $season) {
        $count = Season::where('Year', $year)->count();
        $findSeason = Season::where('Year', $year)->get()->first();

        if($count >= 2) {
            return true;
        } else {
            if($count && $findSeason->Season === $season) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function seedissuancehistory(): HasMany {
        return $this->hasMany(SeedIssuanceHistory::class, 'season_id', 'id');
    }
}
