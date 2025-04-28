<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'contact_person',
        'telp',
        'email',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];
}