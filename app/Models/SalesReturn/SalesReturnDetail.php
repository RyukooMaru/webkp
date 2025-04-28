<?php

namespace App\Models\SalesReturn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesReturnDetail extends Model
{
    protected $table = 'sales_return_details';
    public $timestamps = false;
    protected $fillable = [
        'Trx_SupCode',
        'trx_number',
        'Trx_date',
        'Trx_ProdCode',
        'trx_prodname',
        'trx_uom',
        'trx_curr',
        'Trx_QtyTrx',
        'Trx_QtyReject',
        'Trx_QtyBonus',
        'Trx_QtyBayar',
        'Trx_GrossPrice',
        'Trx_NettPrice',
        'Trx_Discount',
        'Trx_Taxes',
        'trx_cogs',
        'trx_rev',
        'trx_posting',
        'Trx_Note',
        'Trx_UpdateID',
        'Trx_LastUpdate'
    ];

    public function header(): BelongsTo
    {
        return $this->belongsTo(SalesReturnHeader::class, 'trx_number', 'trx_number'); // inverse :contentReference[oaicite:12]{index=12}
    }
}
