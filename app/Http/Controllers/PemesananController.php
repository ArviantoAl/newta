<?php

namespace App\Http\Controllers;

use App\Mail\MailAdmins;
use App\Models\District;
use App\Models\Kategori;
use App\Models\Langganan;
use App\Models\Layanan;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PemesananController extends Controller
{
    public function pemesanan(){
        $user = User::query()->where('user_role', '=', 4)->get();
        $kategori = Kategori::all();
        $provinsi = Province::all();

//        dd($kategori);
        return view('dashboard.admin.pemesanan.pemesanan', compact('user', 'kategori', 'provinsi'));
    }

    public function pelanggan_baru(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
        ]);
        $pass = rand(100000, 999999);
        $password = Hash::make($pass);
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $no_hp = $request->no_hp;

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->username = $username;
        $user->password = $password;
        $user->user_role = 4;
        $user->no_hp = $no_hp;
        $nama_role = 'Pelanggan';
        $user->save();

        $data_ambil = [
            'nama' => $name,
            'nama_role' => $nama_role,
            'username' => $username,
            'email' => $email,
            'password' => $pass,
        ];

        Mail::to($email)->send(new MailAdmins($data_ambil));

        $getpelanggan_id = User::query()
            ->where('name','=',$name)
            ->where('email','=',$email)
            ->where('username','=',$username)
            ->where('no_hp','=',$no_hp)
            ->get()
            ->toArray();
        $objectToArray = (array)$getpelanggan_id;
        $pel1 = $objectToArray[0];
        $pel2 = (array)$pel1;
        $pelanggan_id = $pel2['id_user'];

        $layanan_id = $request->id_layanan;
        $getlayanan = Layanan::query()
            ->where('id_layanan', $request->id_layanan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlayanan;
        $lay1 = $objectToArray[0];
        $lay2 = (array)$lay1;
        $harga = $lay2['harga'];

        $langganan = new Langganan();
        $langganan->pelanggan_id = $pelanggan_id;
        $langganan->layanan_id = $layanan_id;

        $getprovinsi = Province::query()
            ->where('id', $request->id_provinsi)
            ->get()
            ->toArray();
        $objectToArray = (array)$getprovinsi;
        $prov1 = $objectToArray[0];
        $prov2 = (array)$prov1;
        $provinsi = $prov2['name'];

        $getkabupaten = Regency::query()
            ->where('id', $request->id_kabupaten)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkabupaten;
        $kab1 = $objectToArray[0];
        $kab2 = (array)$kab1;
        $kabupaten = $kab2['name'];

        $getkecamatan = District::query()
            ->where('id', $request->id_kecamatan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkecamatan;
        $kec1 = $objectToArray[0];
        $kec2 = (array)$kec1;
        $kecamatan = $kec2['name'];

        $getdesa = Village::query()
            ->where('id', $request->id_desa)
            ->get()
            ->toArray();
        $objectToArray = (array)$getdesa;
        $desa1 = $objectToArray[0];
        $desa2 = (array)$desa1;
        $desa = $desa2['name'];

        $alamat = $request->id_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);
        $langganan->status = '0';
        $langganan->harga_satuan = $harga;
        $langganan->save();

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

    public function pelanggan_lama(Request $request){
        $layanan_id = $request->id_layanan;
        $getlayanan = Layanan::query()
            ->where('id_layanan', $request->id_layanan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlayanan;
        $lay1 = $objectToArray[0];
        $lay2 = (array)$lay1;
        $harga = $lay2['harga'];

        $langganan = new Langganan();
        $langganan->pelanggan_id = $request->id_user;
        $langganan->layanan_id = $layanan_id;

        $getprovinsi = Province::query()
            ->where('id', $request->id_provinsi)
            ->get()
            ->toArray();
        $objectToArray = (array)$getprovinsi;
        $prov1 = $objectToArray[0];
        $prov2 = (array)$prov1;
        $provinsi = $prov2['name'];

        $getkabupaten = Regency::query()
            ->where('id', $request->id_kabupaten)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkabupaten;
        $kab1 = $objectToArray[0];
        $kab2 = (array)$kab1;
        $kabupaten = $kab2['name'];

        $getkecamatan = District::query()
            ->where('id', $request->id_kecamatan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkecamatan;
        $kec1 = $objectToArray[0];
        $kec2 = (array)$kec1;
        $kecamatan = $kec2['name'];

        $getdesa = Village::query()
            ->where('id', $request->id_desa)
            ->get()
            ->toArray();
        $objectToArray = (array)$getdesa;
        $desa1 = $objectToArray[0];
        $desa2 = (array)$desa1;
        $desa = $desa2['name'];

        $alamat = $request->id_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);
        $langganan->status = '0';
        $langganan->harga_satuan = $harga;
        $langganan->save();

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

//    get from ajax
    public function get_layanan(Request $request){
        $id_kategori = $request->id_kategori;

        $layanans = Layanan::query()
            ->where('layanan_kategori', $id_kategori)
            ->orderBy('nama_layanan', 'ASC')
            ->get();

        $option = "<option>Pilih Layanan</option>";
        foreach ($layanans as $layanan){
            $option .= "<option value='$layanan->id_layanan'>$layanan->nama_layanan</option>";
        }
        echo $option;
    }

    public function getKabupaten(Request $request)
    {
        $id_provinsi = $request->id_provinsi;

        $kabupatens = Regency::query()
            ->where('province_id', $id_provinsi)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option>Pilih Kabupaten</option>";
        foreach ($kabupatens as $kabupaten){
            $option .= "<option value='$kabupaten->id'>$kabupaten->name</option>";
        }
        echo $option;
    }

    public function getKecamatan(Request $request)
    {
        $id_kabupaten = $request->id_kabupaten;

        $kecamatans = District::query()
            ->where('regency_id', $id_kabupaten)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option>Pilih Kecamatan</option>";
        foreach ($kecamatans as $kecamatan){
            $option .= "<option value='$kecamatan->id'>$kecamatan->name</option>";
        }
        echo $option;
    }

    public function getDesa(Request $request)
    {
        $id_kecamatan = $request->id_kecamatan;

        $desas = Village::query()
            ->where('district_id', $id_kecamatan)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option>Pilih Desa</option>";
        foreach ($desas as $desa){
            $option .= "<option value='$desa->id'>$desa->name</option>";
        }
        echo $option;
    }
}
