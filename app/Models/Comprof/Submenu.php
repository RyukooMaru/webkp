<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submenu extends Model
{
    protected $table = 'submenu_tabel';
    
    protected $fillable = [
        'menu_id',
        'nama_submenu', 
        'urut',
        'tautan',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    // Accessor untuk status HTML
    public function getStatusHtmlAttribute(): string
    {
        return $this->status
            ? '<span class="badge">Aktif</span>'
            : '<span class="badge">Tidak Aktif</span>';
    }
}