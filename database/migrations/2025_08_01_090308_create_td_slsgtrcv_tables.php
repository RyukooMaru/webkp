<?php

namespace App\Models\MutasiGudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerimaGudangHeader extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'th_slsgtrcv';

    // Kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'Rcv_number',
        'ref_trx_auto', // Referensi ke ID transfer gudang
        'user_id',
        'Rcv_Date',
        'Rcv_WareCode', // Gudang penerima
        'Rcv_From',     // Gudang pengirim
        'rcv_posting',
        'Rcv_Note',
    ];

    // Relasi ke detail barang
    public function details()
    {
        return $this->hasMany(TerimaGudangDetail::class, 'terima_gudang_id', 'id');
    }

    // Opsional: Relasi ke model Transfer Gudang (jika ada)
    // public function transferGudang()
    // {
    //     return $this->belongsTo(TransferGudangHeader::class, 'ref_trx_auto', 'Trx_Auto');
    // }
}
