<?php

namespace App\Models\Comprof;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'comprof_menus';
    
    protected $fillable = [
        'nama_menu',
        'slug',
        'route',
        'urutan',
        'status',
        'parent_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('urutan');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Aktif' : 'Tidak Aktif';
    }
}