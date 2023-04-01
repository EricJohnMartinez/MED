<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonRestricted extends Model
{
    use HasFactory;

    protected $table = 'nonrestricteddrugs';

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

    // public function scopeFilter($query, array $filters)
    // {
    //     if ($filters['search'] ?? false){
    //         $query->where('name', 'like', '%'. request('search').'%')
    //         ->orWhere('drug', 'like', '%'. request('search').'%');
    //     }
    // }
}
