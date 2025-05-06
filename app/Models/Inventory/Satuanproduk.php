<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Satuanproduk extends Model
{
    protected $table = 'm_uom';
    protected $primaryKey = 'UOM_Auto';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'UOM_Code',
        'UOM_Amount',
        'UOM_EntryID',
        'UOM_Entrydate',
        'UOM_UpdateID'
    ];
}