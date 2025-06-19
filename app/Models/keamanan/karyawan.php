<?php

namespace App\Models\keamanan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional: jika Anda ingin menggunakan model factories

class Karyawan extends Model
{
    use HasFactory; // Opsional: untuk menggunakan model factories

    // Nama tabel yang terkait dengan model ini
    protected $table = 'm_karyawan';

    // Mendefinisikan primary key dari tabel
    // Berdasarkan migrasi yang Anda berikan, Kar_ID adalah primary key
    protected $primaryKey = 'Kar_ID';

    // Karena Kar_ID adalah string dan bukan auto-increment integer, set ini menjadi false
    public $incrementing = false;

    // Tipe data primary key (defaultnya int). Karena Kar_ID adalah string, definisikan sebagai string.
    protected $keyType = 'string';

    // Nonaktifkan timestamps (created_at dan updated_at) jika tabel tidak memiliki kolom ini
    // Berdasarkan migrasi dummy yang saya buat, ada timestamps, jadi ini bisa diaktifkan atau dinonaktifkan
    // Jika tabel m_karyawan Anda tidak memiliki created_at dan updated_at, biarkan false.
    public $timestamps = true; // Set ke `false` jika tidak ada kolom `created_at` dan `updated_at`

    // Kolom-kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'Kar_ID',
        'Kar_Nama',
        // Tambahkan semua kolom lain yang ingin Anda izinkan untuk diisi secara massal
        // 'Kar_Alamat',
        // 'Kar_Telepon',
    ];

    // Jika Anda ingin mendefinisikan relasi ke model Member (opsional, jika Anda perlu mencari Member dari Karyawan)
    // Misalnya, satu karyawan bisa memiliki satu entri Member
    public function member()
    {
        return $this->hasOne(Member::class, 'Mem_ID', 'Kar_ID');
    }
}
