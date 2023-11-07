<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poultry extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Poultry_Type',
        'Quantity',
        'personal_information_id'
    ];


    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'personal_information_id', 'id');
    }
}
