<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_unit_layanan')->insertOrIgnore([
            'unit_layanan' => 'UGD',
            'keterangan' => 'Unit Layanan Utama',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
