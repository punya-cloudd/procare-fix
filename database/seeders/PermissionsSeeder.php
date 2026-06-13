<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Role & Permission
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            // Data Pengguna
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            // Dashboard
            'dashboard-view',

            // Data Master
            'satuan-obat-list',
            'satuan-obat-create',
            'satuan-obat-edit',
            'satuan-obat-delete',

            'unit-layanan-list',
            'unit-layanan-create',
            'unit-layanan-edit',
            'unit-layanan-delete',

            'gudang-list',
            'gudang-create',
            'gudang-edit',
            'gudang-delete',

            'peserta-list',
            'peserta-create',
            'peserta-edit',
            'peserta-delete',

            'obat-list',
            'obat-create',
            'obat-edit',
            'obat-delete',

            // Transaksional
            'transaksi-list',
            'transaksi-create',
            'transaksi-edit',
            'transaksi-delete',
            'transaksi-update-status',

            'history-transaksi-view',
            'export-pdf',
            'export-excel',

            'qrcode-list',
            'qrcode-create',
            'qrcode-edit',
            'qrcode-delete',

            'menu-data-master',
            'menu-transaksional'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
