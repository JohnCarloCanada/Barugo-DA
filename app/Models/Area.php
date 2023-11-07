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
        'personal_information_id',
        'Hectares',
        'Area_Type',
        'Commodity_planted',
        'Address',
        'Ownership_Type',
        'Tenant_Name',
        'Owner_Address',
        'Lat',
        'Lon',
        'Farm_Type',
        'is_claimed'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas';


    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'personal_information_id', 'id');
    }
}
