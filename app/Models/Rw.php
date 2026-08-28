<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rw_number',
        'alamat',
        'phone_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function residents()
    {
        return $this->hasMany(User::class, 'rw_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function getFullNameAttribute()
    {
        return "RW {$this->rw_number}";
    }
}