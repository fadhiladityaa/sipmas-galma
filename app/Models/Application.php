<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'rt_id',
        'application_number',
        'status',
        'data',
        'notes',
        'rejected_reason',
        'staff_id',
        'submitted_at',
        'processed_at',
        'issued_at',
        'rt_approved_at', // tambahkan
        'rt_approved_by', // tambahkan
        'rt_rejection_reason', // tambahkan
    ];

    protected $casts = [
        'data' => 'array',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }

    // Relasi
    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    public function rtApprovedBy()
    {
        return $this->belongsTo(User::class, 'rt_approved_by');
    }

    // Helper: cek status
    public function isWaitingRt()
    {
        return $this->status === 'menunggu_rt';
    }

    public function letter()
    {
        return $this->hasOne(Letter::class);
    }

    public function isApprovedRt()
    {
        return $this->status === 'disetujui_rt';
    }

    public function isRejectedRt()
    {
        return $this->status === 'ditolak_rt';
    }

    public function getFormattedData()
{
    if (!$this->data) {
        return [];
    }
    

    // Definisikan label yang lebih user-friendly untuk setiap field
    $fieldLabels = [
        'keperluan' => 'Keperluan',
        'penghasilan' => 'Penghasilan per Bulan',
        'penghasilan_keluarga' => 'Penghasilan Keluarga',
        'pekerjaan_orang_tua' => 'Pekerjaan Orang Tua',
        'jumlah_tanggungan' => 'Jumlah Tanggungan',
        'jenis_usaha' => 'Jenis Usaha',
        'lama_usaha' => 'Lama Usaha',
        'alamat_usaha' => 'Alamat Usaha',
        'tanggal_acara' => 'Tanggal Acara',
        'lokasi' => 'Lokasi Acara',
        'jenis_acara' => 'Jenis Acara',
        'waktu_mulai' => 'Waktu Mulai',
        'waktu_selesai' => 'Waktu Selesai',
        'jenis_kendaraan' => 'Jenis Kendaraan',
        'jumlah_bbm' => 'Jumlah BBM (liter/hari)',
        'tujuan' => 'Tujuan Penggunaan',
        'nomor_polisi' => 'Nomor Polisi',
        'tujuan_surat' => 'Tujuan Surat',
        'tanggal_meninggal' => 'Tanggal Meninggal',
        'tempat_meninggal' => 'Tempat Meninggal',
        'penyebab' => 'Penyebab Kematian',
        'nama_saksi' => 'Nama Saksi',
        'luas_tanah' => 'Luas Tanah (m²)',
        'nomor_sppt' => 'Nomor SPPT',
        'alamat_tanah' => 'Alamat Tanah',
        'batas_utara' => 'Batas Utara',
        'batas_selatan' => 'Batas Selatan',
        'batas_timur' => 'Batas Timur',
        'batas_barat' => 'Batas Barat',
        'keperluan_skck' => 'Keperluan SKCK',
        'alasan' => 'Alasan',
        'lama_tinggal' => 'Lama Tinggal (tahun)',
        'custom_service_name' => 'Nama Surat (Lainnya)',
    ];

        $formatted = [];
        foreach ($this->data as $key => $value) {
            $label = $fieldLabels[$key] ?? ucfirst(str_replace('_', ' ', $key));
            $formatted[] = [
                'label' => $label,
                'value' => $value,
            ];
        }

        return $formatted;
    }
}