<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;

class KategoriAlbum extends Model
{
    protected $table = 'kategori_album';

    protected $fillable = [
        'kategori_album',
        'tampil_gallery'
    ];

    protected $casts = [
        'tampil_gallery' => 'boolean'
    ];

    public function getTampilGalleryLabelAttribute()
    {
        return $this->tampil_gallery ? 'Tampil Gallery' : 'Tidak Tampil Gallery';
    }

    public function getTampilGalleryHtmlAttribute()
    {
        return $this->tampil_gallery 
            ? '<span class="badge">Tampil Gallery</span>' 
            : '<span class="badge">Tidak Tampil Gallery</span>';
    }
}