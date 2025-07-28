<?php

namespace App\Models\SPModels;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class PenjualanDetail extends Model
{
    /**
     * The table associated with the model.
     * Diubah menjadi 'penjualan_details' agar sesuai dengan migrasi.
     * @var string
     */
    protected $table = 'penjualan_details';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    /**
     * Get the main sale record that this detail belongs to.
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    /**
     * Get the product for this sale detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
