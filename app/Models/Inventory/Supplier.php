<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    protected $table = 'suppliers';
    
    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'contact_person',
        'telp',
        'email',
        'cara_bayar_id',
        'lama_bayar',
        'potongan',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function caraBayar(): BelongsTo
    {
        return $this->belongsTo(CaraBayar::class);
    }
}