<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restricted extends Model
{
    use HasFactory;

    protected $table = 'restricteddrugs';
    
    protected $fillable = [
        'name',
        'date',
        'ward',
        'drug',
        'dosege',
        'total',
        'nurse',
        'pharmacist'

    ];

}
