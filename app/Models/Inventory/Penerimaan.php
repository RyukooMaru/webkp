<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penerimaan extends Model
{
    protected $table = 'penerimaan';
    protected $primaryKey = 'penerimaan_id';
    
    protected $fillable = [
        'no_penerimaan',
        'supplier_id',
        'po_id',
        'tgl_terima',
        'gudang',
        'faktur',
        'jatuh_tempo',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tgl_terima' => 'date',
        'jatuh_tempo' => 'date'
    ];

    protected $attributes = [
        'status' => 'draft'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PenerimaanDetail::class, 'penerimaan_id');
    }

    public function getTotalAttribute()
    {
        return $this->details->sum('subtotal');
    }

    public function canEdit(): bool
    {
        return $this->status === 'draft';
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($penerimaan) {
            $penerimaan->details()->delete();
        });
    }
}