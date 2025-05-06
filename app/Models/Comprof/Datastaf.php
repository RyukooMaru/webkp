<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Datastaf extends Model
{
    use SoftDeletes;

    protected $table = 'datastaf_tabel';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'jabatan',
        'profile_image',
        'description',
        'education',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getStatusAttribute($value): string
    {
        return $value ? 'Aktif' : 'Nonaktif';
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : asset('images/default-profile.png');
    }
}