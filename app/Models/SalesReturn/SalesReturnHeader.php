<?php

namespace App\Models\SalesReturn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesReturnHeader extends Model
{
    protected $table = 'sales_return_headers';                             // nama tabel kustom :contentReference[oaicite:10]{index=10}
    protected $primaryKey = 'Trx_Auto';                                    // PK kustom
    public $timestamps = false;                                            // non-standar timestamps
    protected $fillable = [                                                // kolom yang boleh diisi massal
        'Trx_SupCode',
        'Trx_WareCode',
        'trx_jurnal',
        'trx_sourcenum',
        'trx_number',
        'Trx_Discount',
        'Trx_FakturNo',
        'Trx_Date',
        'Trx_FakturDate',
        'Trx_DueDate',
        'trx_curr',
        'Trx_GrossPrice',
        'Trx_NettPrice',
        'Trx_Taxes',
        'Trx_TotDiscount',
        'trx_status',
        'Trx_Note',
        'trx_payment',
        'trx_clear',
        'trx_posting',
        'Trx_Print',
        'Trx_BON',
        'trx_rev',
        'Trx_MerchandiserID',
        'Trx_UserID',
        'Trx_LastUpdate'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(SalesReturnDetail::class, 'trx_number', 'trx_number'); // relasi via trx_number :contentReference[oaicite:11]{index=11}
    }
}
