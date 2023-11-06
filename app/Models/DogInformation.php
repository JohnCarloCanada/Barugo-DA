<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DogInformation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Dog_Name',
        'Owner_Name',
        'Species',
        'Sex',
        'Age',
        'Neutering',
        'Color',
        'Date_of_Registration',
        'Last_Vac_Month',
        'Remarks',
        'RSBSA_No',
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'DogID';

    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'RSBSA_No', 'RSBSA_No');
    }
}
