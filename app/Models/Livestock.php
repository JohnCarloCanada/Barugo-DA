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
        'personal_information_id',
        'quantity'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    public function personalinformation(): BelongsTo {
        return $this->belongsTo(PersonalInformation::class, 'personal_information_id', 'id');
    }
}
