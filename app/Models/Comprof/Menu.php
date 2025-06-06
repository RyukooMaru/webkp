<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Menu extends Model
{
    protected $table = 'setmenu';

    protected $fillable = [
        'nama_menu',
        'urutan',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relasi ke submenu
    public function submenus(): HasMany
    {
        return $this->hasMany(Submenu::class, 'menu_id');
    }

    // Accessor untuk label status
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Aktif' : 'Tidak Aktif';
    }

    // Accessor untuk status dalam format HTML
    public function getStatusHtmlAttribute(): string
    {
        return $this->status 
            ? '<span class="badge bg-success">Aktif</span>' 
            : '<span class="badge bg-danger">Tidak Aktif</span>';
    }
}