<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompokproduk extends Model
{
    use HasFactory;

    protected $table = 'kelompokproduk_tabel';
    protected $fillable = ['nama_kelompok']; 
}
