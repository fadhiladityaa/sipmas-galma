<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'rt_id'
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

    // Relasi
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function rt()
    {
        return $this->belongsTo(Rt::class);
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

    public function hasCompleteProfile()
    {
        // Field yang wajib diisi untuk pengajuan surat
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
