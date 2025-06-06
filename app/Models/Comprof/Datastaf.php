<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Datastaf extends Model
{
    protected $table = 'datastaf_tabel';
    protected $fillable = [
        'name',
        'jabatan',
        'profile_image',
        'description',
        'education',
        'status' // PASTIKAN STATUS ADA DI FILLABLE
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            // PERBAIKAN: Gunakan asset helper dengan benar
            return Storage::disk('public')->exists($this->profile_image) 
                ? asset('storage/' . $this->profile_image)
                : asset('images/default-profile.png');
        }
        return asset('images/default-profile.png');
    }
}