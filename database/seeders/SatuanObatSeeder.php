<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SatuanObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy untuk tabel m_satuan_obat
        $data = [
            [
                'nama_satuan' => 'Tablet',
                'keterangan' => 'Satuan obat berbentuk tablet',
                'created_by' => 1, // ID user yang membuat (misalnya admin)
                'updated_by' => 1, // ID user yang mengupdate (misalnya admin)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_satuan' => 'Kapsul',
                'keterangan' => 'Satuan obat berbentuk kapsul',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_satuan' => 'Botol',
                'keterangan' => 'Satuan obat berbentuk botol',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_satuan' => 'Strip',
                'keterangan' => 'Satuan obat berbentuk strip',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Masukkan data ke tabel m_satuan_obat
        DB::table('m_satuan_obat')->insert($data);
    }
}