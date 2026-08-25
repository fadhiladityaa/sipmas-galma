<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'staff_id',
        'template_id',
        'letter_number',
        'content',
        'pdf_path',
        'signed_pdf_path',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function getFormattedContent()
    {
        // Parse placeholder dan return HTML/PDF content
        return $this->content;
    }
    
     // Helper: cek apakah PDF sudah ada
    public function hasPdf()
    {
        return !empty($this->pdf_path) && file_exists(storage_path('app/public/' . $this->pdf_path));
    }

    // Helper: URL untuk download PDF
    public function getPdfUrl()
    {
        if ($this->hasPdf()) {
            return asset('storage/' . $this->pdf_path);
        }
        return null;
    }
}