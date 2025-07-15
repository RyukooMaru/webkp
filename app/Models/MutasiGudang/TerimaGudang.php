<?php

namespace App\Models\MutasiGudang;

use Illuminate\Database\Eloquent\Model;

class TerimaGudang extends Model
{
    // Nama tabel di database
    protected $table = 'td_gudangorder';

    // Nama primary key selain 'id'
    protected $primaryKey = 'Rec_Auto';

    // Matikan timestamps jika tidak ada created_at dan updated_at
    public $timestamps = false;

    // --- DIUBAH ---
    // Kolom-kolom ini disesuaikan 100% dengan screenshot database Anda
    // dan form yang akan kita buat.
    protected $fillable = [
        'Rec_ordernumber', // Untuk nomor penerimaan, BUKAN Pur_Number
        'Pur_SupCode',     // Untuk gudang pengirim
        'pur_ordernumber', // Untuk nomor permintaan/order asli
        'pur_warehouse',   // Untuk gudang penerima
        'Pur_Date',
        'Pur_ProdCode',
        'pur_prodname',
        'Pur_Qty',
        'Pur_QtyRecv',
        'Pur_BonusCode',
        'Pur_QtyBonus',
        'Pur_Discount',
        'Pur_GrossPrice',
        'Pur_NettPrice',
        'Pur_Taxes',
        'pur_uom',
        'pur_curr',
        'Pur_Note',
        'Pur_Cancel',
        'Pur_UpdateID',
        'Pur_LastUpdate'
    ];

    public function gudangPenerima()
    {
        return $this->belongsTo(Warehouse::class, 'pur_warehouse', 'WARE_Auto'); // <-- PERIKSA SETIAP PARAMETER
    }

    /**
     * Relasi ke Gudang Pengirim
     * Pastikan 'Pur_SupCode' adalah nama kolom ID gudang pengirim di tabel 'td_gudangorder'
     */
    public function gudangPengirim()
    {
        return $this->belongsTo(Warehouse::class, 'Pur_SupCode', 'WARE_Auto'); // <-- PERIKSA SETIAP PARAMETER
    }

}
