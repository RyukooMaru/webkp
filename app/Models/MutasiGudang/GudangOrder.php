<?php

namespace App\Models\MutasiGudang;

use Illuminate\Database\Eloquent\Model;

class GudangOrder extends Model
{
    // Nama tabel
    protected $table = 'th_gudangorder';

    // Primary key
    protected $primaryKey = 'Pur_Auto';

    // Primary key bukan tipe UUID
    public $incrementing = true;

    // Tipe primary key adalah integer
    protected $keyType = 'int';

    // Tidak menggunakan created_at dan updated_at default Laravel
    public $timestamps = false;

    // Kolom-kolom yang dapat diisi melalui mass-assignment
    protected $fillable = [
        'Pur_SupCode',
        'pur_ordernumber',
        'pur_warehouse',
        'pur_emp',
        'Pur_Date',
        'Pur_Discount',
        'Pur_GrossPrice',
        'Pur_NettPrice',
        'Pur_Taxes',
        'Pur_TotDiscount',
        'Pur_Group',
        'Pur_Note',
        'Pur_Cancel',
        'pur_status',
        'Pur_FLAG',
        'Pur_Print',
        'pur_rev',
        'Pur_UpdateID',
        'Pur_LastUpdate',
    ];

    // Jika ingin menambahkan casting tipe data (opsional tapi membantu)
    protected $casts = [
        'Pur_Date' => 'date',
        'Pur_LastUpdate' => 'datetime',
        'Pur_Discount' => 'float',
        'Pur_GrossPrice' => 'decimal:2',
        'Pur_NettPrice' => 'decimal:2',
        'Pur_Taxes' => 'decimal:2',
        'Pur_TotDiscount' => 'decimal:2',
        'Pur_Print' => 'integer',
        'pur_rev' => 'integer',
    ];
}
