<?php

namespace App\Models\Akuntansi;

use App\Models\User; // Pastikan namespace User benar
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccHdjurnal extends Model
{
    use HasFactory;

    protected $table = 'acc_hd_jurnal';
    protected $fillable = [
        'no_jurnal',
        'tanggal_buat',
        'tanggal_edit',
        'lokasi_nama', // Ganti ke lokasi_id nanti
        'referensi',
        'catatan',
        'user_id',
        'nominal',
    ];

    protected $casts = [
        'tanggal_buat' => 'date',
        'tanggal_edit' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    // Relasi ke Detail Jurnal
    public function details(): HasMany
    {
        return $this->hasMany(AccDtjurnal::class, 'acc_hd_jurnal_id');
    }

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
