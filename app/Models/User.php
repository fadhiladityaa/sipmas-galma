<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'pekerjaan',
        'nomor_hp',
        'ktp_path',
        'kk_path',
        'rt_id',
        'rw_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
        ];
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // ==========================================
    // RELASI WARGA
    // ==========================================

    // RT tempat tinggal warga
    public function rt()
    {
        return $this->belongsTo(Rt::class, 'rt_id');
    }

    // RW tempat tinggal warga
    public function rw()
    {
        return $this->belongsTo(Rw::class, 'rw_id');
    }

    // ==========================================
    // RELASI AKUN RW
    // ==========================================

    // Data RW yang dimiliki oleh akun RW
    public function rwProfile()
    {
        return $this->hasOne(Rw::class, 'user_id');
    }

    // ==========================================
    // RELASI LAIN
    // ==========================================

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isRw()
    {
        return $this->role === 'rw';
    }

    public function isWarga()
    {
        return $this->role === 'warga';
    }

    public function isRt()
    {
        return $this->role === 'rt';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // ==========================================
    // CEK KELENGKAPAN PROFIL WARGA
    // ==========================================

    public function hasCompleteProfile()
    {
        $requiredFields = [
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'agama',
            'pekerjaan',
            'nomor_hp',
            'ktp_path',
            'kk_path',
            'rt_id',
            'rw_id',
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    public function getMissingProfileFields()
    {
        $requiredFields = [
            'nik' => 'NIK',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'agama' => 'Agama',
            'pekerjaan' => 'Pekerjaan',
            'nomor_hp' => 'Nomor HP',
            'ktp_path' => 'Upload KTP',
            'kk_path' => 'Upload KK',
            'rt_id' => 'Pilih RT',
            'rw_id' => 'Pilih RW',
        ];

        $missing = [];

        foreach ($requiredFields as $field => $label) {
            if (empty($this->$field)) {
                $missing[] = $label;
            }
        }

        return $missing;
    }
}