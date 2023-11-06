<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Machinery extends Model
{
    use HasFactory;

    protected $fillable = [
        'MachineName',
        'Price',
        'Mode_Acqusition',
        'Use_of_Machinery',
        'RSBSA_No',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'machinerys';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'MachineID';

    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'RSBSA_No', 'RSBSA_No');
    }
}
