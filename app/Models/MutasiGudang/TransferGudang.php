<?php

namespace App\Models\MutasiGudang;

use Illuminate\Database\Eloquent\Model;

class TransferGudang extends Model
{
    // Nama tabel secara eksplisit
    protected $table = 'th_transfergudang';

    // Primary key dari tabel
    protected $primaryKey = 'Transfer_Auto';

    // Tidak menggunakan timestamp (created_at dan updated_at)
    public $timestamps = false;

    // Kolom yang dapat diisi secara mass-assignment
    protected $fillable = [
        'Transfer_Number',
        'Transfer_FromWarehouse',
        'Transfer_ToWarehouse',
        'Transfer_Date',
        'Transfer_ByEmp',
        'Transfer_Note',
        'Transfer_GrossPrice',
        'Transfer_Discount',
        'Transfer_Taxes',
        'Transfer_NettPrice',
        'Transfer_Status',
        'Transfer_FLAG',
        'Transfer_Cancel',
        'Transfer_Print',
        'Transfer_Rev',
        'Transfer_UpdateID',
        'Transfer_LastUpdate',
        'pur_ordernumber', // sambungan ke permintaan
    ];

public function fromWarehouse()
{
    return $this->belongsTo(\App\Models\MutasiGudang\Warehouse::class, 'Transfer_FromWarehouse', 'WARE_Auto');
}

public function toWarehouse()
{
    return $this->belongsTo(\App\Models\MutasiGudang\Warehouse::class, 'Transfer_ToWarehouse', 'WARE_Auto');
}

public function permintaan()
{
    return $this->belongsTo(GudangOrder::class, 'pur_ordernumber', 'pur_ordernumber');
}


}
