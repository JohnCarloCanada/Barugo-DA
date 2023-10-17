<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;

    protected $fillable = [
        'religion',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'religions';
}
