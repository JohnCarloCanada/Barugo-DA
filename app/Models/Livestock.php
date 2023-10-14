<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livestock extends Model
{
    use HasFactory;

    protected $fillable = [
        'LSAnimals',
        'Sex_LS',
        'RSBSA_No',
    ];

    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'RSBSA_No', 'RSBSA_No');
    }
}
