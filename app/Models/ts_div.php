<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ts_div extends Model
{
    use HasFactory;
    protected $table = 'ts_div';
    protected $primaryKey = 'div_auto';
    public $timestamps = false; // <-- tambahkan ini!

    protected $fillable = [
        'Div_Code',
        'Div_Name',
        'DIV_NIK',
        'DIV_SHIFTYN',
        'DIV_BIAYA',
        'Div_EntryID',
        'Div_Entrydate',
        'Div_UserID',
        'Div_LastUpdate',
    ];
}
