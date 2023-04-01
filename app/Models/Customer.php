<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
        'email',
        'phone',
        'address',
        'avatar',
        'user_id',
        'room_number',
        'date_of_birth',
        'philhealth',
        'sex',
        'height',
        'weight',
        'marital_status',
        'emergency',

        'medicines',
        'name_of_nurse',
        'progress_notes',
        'doctors_order',
        'remarks',
        'prepared_by',
        'medical_history',
        'medications',
        'restricted_drugs',

        'doctor_name',
        'medicines_fluids',
        'requested',
        'dispensed',
        'pharacist_duty',
        'nurse_duty',
        'daily_remarks',
    ];
    public function scopeFilter($query, array $filters)
{
    if ($filters['search'] ?? false){
        $query->where('first_name', 'like', '%'. request('search').'%')
        ->orWhere('last_name', 'like', '%'. request('search').'%');
    }
}
    public function getAvatarUrl()
    {
        return Storage::url($this->avatar);
    }
}
