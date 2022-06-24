<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        1
        $role = [
            [
                'nama_role' => 'Admin',
            ],
            [
                'nama_role' => 'Administrator',
            ],
            [
                'nama_role' => 'Keuangan',
            ],
            [
                'nama_role' => 'Pelanggan',
            ],
        ];
        DB::table('roles')->insert($role);

//        2
        $user = [
            [
                'name' => 'admin',
                'email' => 'user@admin.com',
                'username' => 'admincv2022',
                'password' => Hash::make('23456789'),
                'user_role' => 1,
            ],
            [
                'name' => 'pane',
                'email' => 'panet@user.com',
                'username' => 'panet',
                'password' => Hash::make('12341234'),
                'user_role' => 4,
            ]
        ];
        DB::table('users')->insert($user);

//        3
        $kategori = [
            [
                'nama_kategori' => 'internet',
            ],
            [
                'nama_kategori' => 'hardware',
            ],
        ];
        DB::table('kategoris')->insert($kategori);

//        4
        $layanan = [
            [
                'nama_layanan' => '5 mbps',
                'harga' => 100000,
                'layanan_kategori' => 1
            ],
            [
                'nama_layanan' => '10 mbps',
                'harga' => 200000,
                'layanan_kategori' => 1
            ],
            [
                'nama_layanan' => 'WiFi Travel',
                'harga' => 150000,
                'layanan_kategori' => 2
            ],
        ];
        DB::table('layanans')->insert($layanan);
    }
}
