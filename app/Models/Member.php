<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'membership_number',
        'membership_start_date',
        'membership_end_date',
        'qr_code',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'membership_start_date' => 'date',
        'membership_end_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected $appends = ['full_name', 'photo_url'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function scans()
    {
        return $this->hasMany(MemberScan::class);
    }
}
