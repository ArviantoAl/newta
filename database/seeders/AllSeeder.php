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

        $status = [
            [
                'kategori_tabel' => 'user, langganan',
                'nama_status' => 'On Progress',
            ],
            [
                'kategori_tabel' => 'user, langganan',
                'nama_status' => 'Pending',
            ],
            [
                'kategori_tabel' => 'user, bts, turunan bts, layanan, langganan',
                'nama_status' => 'Aktif',
            ],
            [
                'kategori_tabel' => 'user, bts, turunan bts, layanan, langganan',
                'nama_status' => 'Non Aktif',
            ],
            [
                'kategori_tabel' => 'langganan',
                'nama_status' => 'Batal',
            ],
            [
                'kategori_tabel' => 'invoice',
                'nama_status' => 'Belum Dibayar',
            ],
            [
                'kategori_tabel' => 'invoice',
                'nama_status' => 'Sudah Dibayar',
            ],
            [
                'kategori_tabel' => 'invoice',
                'nama_status' => 'Lunas',
            ],
            [
                'kategori_tabel' => 'invoice',
                'nama_status' => 'Ditolak',
            ],
        ];
        DB::table('status')->insert($status);

//        2
        $user = [
            [
                'name' => 'admin 1',
                'email' => 'user@admin.com',
                'username' => '087876785956',
                'password' => Hash::make('admin123'),
                'user_role' => 1,
                'status_id' => 3,
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'teknisi 1',
                'email' => 'terknisi@user.com',
                'username' => '087878785456',
                'password' => Hash::make('teknisi321'),
                'user_role' => 2,
                'status_id' => 3,
                'email_verified_at' => Carbon::now(),
            ],
        ];
        DB::table('users')->insert($user);

//        3
        $kategori = [
            [
                'kategori_frekuensi' => '2,4Ghz',
            ],
            [
                'kategori_frekuensi' => '5Ghz',
            ],
        ];
        DB::table('kategoris')->insert($kategori);

//        4
        $jenis = [
            [
                'nama_perangkat' => 'alpha obstacle',
            ],
            [
                'nama_perangkat' => 'tp link',
            ],
            [
                'nama_perangkat' => 'cisa',
            ],
        ];
        DB::table('jenis_bts')->insert($jenis);

        $bts = [
            [
                'nama_bts' => 'BTS jumapolo',
                'kategori_id' => 1,
                'jenis_id' => 2,
                'provinsi_id' => 33,
                'kabupaten_id' => 3313,
                'kecamatan_id' => 3313030,
                'desa_id' => 3313030001,
                'detail_alamat' => 'Dusun gudang RT 1/ RW 7',
                'frekuensi' => '2412',
                'ssid' => 'bts_jumapolo',
                'ip' => '10.113.0.1',
                'status_id' => 3,
            ],
        ];
        DB::table('bts')->insert($bts);

        $layanan = [
            [
                'nama_layanan' => '5 mbps',
                'harga' => 100000,
                'status_id' => 3,
            ],
            [
                'nama_layanan' => '10 mbps',
                'harga' => 200000,
                'status_id' => 3,
            ],
            [
                'nama_layanan' => '15 mbps',
                'harga' => 225000,
                'status_id' => 3,
            ],
        ];
        DB::table('layanans')->insert($layanan);

        $profil = [
            [
                'nama_cv' => 'CV Gdang Media Perkasa',
                'email_cv' => 'info@gudangtechno.web.id',
                'ppn' => 11,
            ],
        ];
        DB::table('profilcv')->insert($profil);
    }
}
