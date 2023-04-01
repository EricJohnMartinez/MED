<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'dailymedications';

    protected $fillable = [
        'name',
        'medicine',
        'requested',
        'dispensed',
        'remarks',
        'nurse',
        'pharmacist'

    ];
}
