<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_gudang')->insert([
            'kode_gudang' => 'G001',
            'nama_gudang' => 'Gudang Utama',
            'lokasi' => 'Lantai 1',
            'keterangan' => 'Gudang utama penyimpanan obat',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
