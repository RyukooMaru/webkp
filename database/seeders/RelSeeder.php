<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelSeeder extends Seeder
{
    public function run(): void
    {
        // Cara Bayar
        DB::table('cara_bayar_tabel')->insert([
            ['id' => 1, 'nama' => 'Cash', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Credit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Transfer', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Suppliers
        DB::table('suppliers')->insert([
            [
                'kode_supplier' => 'SUP-1',
                'nama_supplier' => 'PT Sumber Rejeki',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'contact_person' => 'Budi Santoso',
                'telp' => '021-12345678',
                'email' => 'info@sumberrejeki.com',
                'cara_bayar_id' => 1,
                'lama_bayar' => 30,
                'potongan' => 5.00,
                'tanggal' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_supplier' => 'SUP-2',
                'nama_supplier' => 'CV Berkah Jaya',
                'alamat' => 'Jl. Sudirman No. 456, Bandung',
                'contact_person' => 'Siti Rahayu',
                'telp' => '022-87654321',
                'email' => 'contact@berkahjaya.com',
                'cara_bayar_id' => 2,
                'lama_bayar' => 45,
                'potongan' => 3.50,
                'tanggal' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_supplier' => 'SUP-3',
                'nama_supplier' => 'UD Makmur Abadi',
                'alamat' => 'Jl. Gatot Subroto No. 789, Surabaya',
                'contact_person' => 'Ahmad Wijaya',
                'telp' => '031-11223344',
                'email' => 'admin@makmurabad.com',
                'cara_bayar_id' => 3,
                'lama_bayar' => 60,
                'potongan' => 2.00,
                'tanggal' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Customers
        DB::table('m_customer')->insert([
            ['kode_customer' => 'CUS-1', 'nama_customer' => 'Toko Sinar Abadi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_customer' => 'CUS-2', 'nama_customer' => 'Toko Laris Manis', 'created_at' => now(), 'updated_at' => now()],
            ['kode_customer' => 'CUS-3', 'nama_customer' => 'Toko Makmur Sejahtera', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Warehouses
        DB::table('m_warehouse')->insert([
            [
                'WARE_Name' => 'Gudang A',
                'WARE_Address' => 'Jl. Industri No. 1, Jakarta',
                'WARE_Phone' => '021-1111111',
                'WARE_Fax' => '021-1111112',
                'WARE_Email' => 'gudanga@company.com',
                'WARE_Web' => 'www.company.com',
                'ware_note1' => 'Gudang utama',
                'ware_note2' => 'Kapasitas besar',
                'WARE_EntryDate' => now()
            ],
            [
                'WARE_Name' => 'Gudang B',
                'WARE_Address' => 'Jl. Logistik No. 2, Bandung',
                'WARE_Phone' => '022-2222222',
                'WARE_Fax' => '022-2222223',
                'WARE_Email' => 'gudangb@company.com',
                'WARE_Web' => 'www.company.com',
                'ware_note1' => 'Gudang cabang',
                'ware_note2' => 'Kapasitas sedang',
                'WARE_EntryDate' => now()
            ],
            [
                'WARE_Name' => 'Gudang C',
                'WARE_Address' => 'Jl. Pergudangan No. 3, Surabaya',
                'WARE_Phone' => '031-3333333',
                'WARE_Fax' => '031-3333334',
                'WARE_Email' => 'gudangc@company.com',
                'WARE_Web' => 'www.company.com',
                'ware_note1' => 'Gudang regional',
                'ware_note2' => 'Kapasitas kecil',
                'WARE_EntryDate' => now()
            ],
        ]);

        // Products
        DB::table('dataproduk_tabel')->insert([
            [
                'kode_produk' => 'PRD-1',
                'nama_produk' => 'Celana',
                'supplier_id' => 1, // Mengacu ke ID dari suppliers table
                'qty' => 100,
                'harga_beli' => 15000.00,
                'harga_jual' => 20000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_produk' => 'PRD-2',
                'nama_produk' => 'Kain',
                'supplier_id' => 2,
                'qty' => 200,
                'harga_beli' => 50000.00,
                'harga_jual' => 65000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_produk' => 'PRD-3',
                'nama_produk' => 'Handuk',
                'supplier_id' => 3,
                'qty' => 150,
                'harga_beli' => 25000.00,
                'harga_jual' => 32000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_produk' => 'PRD-4',
                'nama_produk' => 'Baju',
                'supplier_id' => 1,
                'qty' => 50,
                'harga_beli' => 25000.00,
                'harga_jual' => 35000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_produk' => 'PRD-5',
                'nama_produk' => 'Topi',
                'supplier_id' => 3,
                'qty' => 150,
                'harga_beli' => 25000.00,
                'harga_jual' => 30000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // UOM (Unit of Measure)
        DB::table('m_uom')->insert([
            ['UOM_Code' => 'PCS', 'UOM_Amount' => 1.00, 'UOM_EntryID' => 'SYSTEM', 'UOM_Entrydate' => now(), 'UOM_UpdateID' => 'SYSTEM', 'UOM_LastUpdate' => now()],
            ['UOM_Code' => 'KG', 'UOM_Amount' => 1.00, 'UOM_EntryID' => 'SYSTEM', 'UOM_Entrydate' => now(), 'UOM_UpdateID' => 'SYSTEM', 'UOM_LastUpdate' => now()],
            ['UOM_Code' => 'METER', 'UOM_Amount' => 1.00, 'UOM_EntryID' => 'SYSTEM', 'UOM_Entrydate' => now(), 'UOM_UpdateID' => 'SYSTEM', 'UOM_LastUpdate' => now()],
            ['UOM_Code' => 'SET', 'UOM_Amount' => 1.00, 'UOM_EntryID' => 'SYSTEM', 'UOM_Entrydate' => now(), 'UOM_UpdateID' => 'SYSTEM', 'UOM_LastUpdate' => now()],
            ['UOM_Code' => 'BOX', 'UOM_Amount' => 1.00, 'UOM_EntryID' => 'SYSTEM', 'UOM_Entrydate' => now(), 'UOM_UpdateID' => 'SYSTEM', 'UOM_LastUpdate' => now()],
        ]);
    }
}
