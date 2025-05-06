<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submenu extends Model
{
    protected $table = 'submenu_tabel';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'menu_id',
        'nama_submenu', 
        'urut',
        'tautan',
        'status'
    ];

    protected $casts = [
        'entrydate' => 'datetime',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function getStatusAttribute(): string
    {
        return $this->activeyn === 'T' ? 'Aktif' : 'Nonaktif';
    }
}