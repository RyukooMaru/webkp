<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = [
        'title',
        'link',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::disk('public')->exists($this->image) 
                ? asset('storage/' . $this->image)
                : asset('images/default-slider.png');
        }
        return asset('images/default-slider.png');
    }

    public function getStatusHtmlAttribute()
    {
        return $this->status 
            ? '<span class="badge badge-active">Aktif</span>'
            : '<span class="badge badge-inactive">Tidak Aktif</span>';
    }
}