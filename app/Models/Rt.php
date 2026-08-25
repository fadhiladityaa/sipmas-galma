<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rt_number',
        'rw_number',
        'alamat',
        'phone_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke User (akun RT)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke warga (users yang punya rt_id ini)
    public function residents()
    {
        return $this->hasMany(User::class, 'rt_id');
    }

    // Relasi ke pengajuan
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // Helper: nama RT (contoh: "RT 01 RW 03")
    public function getFullNameAttribute()
    {
        $name = "RT {$this->rt_number}";
        if ($this->rw_number) {
            $name .= " RW {$this->rw_number}";
        }
        return $name;
    }
}