<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedInventory extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Seed_Type',
        'Seed_Variety',
        'Company',
        'Quantity',
        'Description',
        'NoHectare',
        'NoBags'
    ];

    // Accessor
    public function getDescriptionAttribute($value)
    {
        // Return the default value if the actual value is null or empty
        return filled($value) ? $value : NULL;
    }
}
