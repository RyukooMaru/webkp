<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dtproduk extends Model
{
    use HasFactory;

    protected $table = 'dataproduk_tabel'; // Sesuai dengan nama tabel migration baru
    
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'supplier_id',
        'qty',
        'harga_beli',
        'harga_jual',
        // Tambahkan field lain sesuai migration
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

