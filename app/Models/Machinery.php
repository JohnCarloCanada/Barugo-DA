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
        'personal_information_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'machinerys';


    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'personal_information_id', 'id');
    }
}
