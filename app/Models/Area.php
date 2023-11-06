<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Lot_No',
        'RSBSA_No',
        'Hectares',
        'Area_Type',
        'Commodity_planted',
        'Address',
        'Ownership_Type',
        'Tenant_Name',
        'Owner_Address',
        'Lat',
        'Lon',
        'Farm_Type'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'RSBSA_No', 'RSBSA_No');
    }
}
