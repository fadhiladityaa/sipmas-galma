<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'is_custom',
        'fields',
    ];

    protected $casts = [
        'fields' => 'array',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}