<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
                'nama_role' => 'Teknisi',
            ],
            [
                'nama_role' => 'Pelanggan',
            ],
        ];
        DB::table('roles')->insert($role);

//        2
        $user = [
            [
                'name' => 'admin 1',
                'email' => 'user@admin.com',
                'username' => 'admincv2022',
                'password' => Hash::make('admin123'),
                'user_role' => 1,
                'status' => '1',
                'no_hp' => '087876785956',
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'teknisi 1',
                'email' => 'terknisi@user.com',
                'username' => 'teknisicv2022',
                'password' => Hash::make('teknisi321'),
                'user_role' => 2,
                'status' => '1',
                'no_hp' => '087878785456',
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'pelanggan 1',
                'email' => 'pelanggan@user.com',
                'username' => 'pelanggan1',
                'password' => Hash::make('12344321'),
                'user_role' => 3,
                'status' => '1',
                'no_hp' => '087876785456',
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'pelanggan 2',
                'email' => 'pelanggan2@user.com',
                'username' => 'pelanggan2',
                'password' => Hash::make('12344321'),
                'user_role' => 3,
                'status' => '0',
                'no_hp' => '089876785456',
                'email_verified_at' => null,
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
        $jenis = [
            [
                'nama_jenis' => '4 kaki',
            ],
            [
                'nama_jenis' => '3 kaki',
            ],
            [
                'nama_jenis' => '1 kaki',
            ],
        ];
        DB::table('jenis_bts')->insert($jenis);

        $bts = [
            [
                'nama_bts' => 'BTS A',
                'jenis_id' => 2,
                'provinsi_id' => 33,
                'kabupaten_id' => 3313,
                'kecamatan_id' => 3313030,
                'desa_id' => 3313030001,
                'detail_alamat' => 'Dusun gudang RT 1/ RW 7',
            ],
        ];
        DB::table('bts')->insert($bts);

        $layanan = [
            [
                'nama_layanan' => '5 mbps',
                'harga' => 100000,
                'layanan_kategori' => 1,
                'status' => 1,
                'bts_id' => 1
            ],
            [
                'nama_layanan' => '10 mbps',
                'harga' => 200000,
                'layanan_kategori' => 1,
                'status' => 1,
                'bts_id' => 1
            ],
            [
                'nama_layanan' => 'WiFi Travel',
                'harga' => 150000,
                'layanan_kategori' => 2,
                'status' => 1,
                'bts_id' => 1
            ],
        ];
        DB::table('layanans')->insert($layanan);
    }
}
