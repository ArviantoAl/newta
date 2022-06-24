<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Langganan;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function index(){
        return view('dashboard.pelanggan.index');
    }

    public function pemesanan(){
        $provincies = Province::all();
        $kategoris = Kategori::all();

        return view('dashboard.pelanggan.pemesanan', compact('kategoris', 'provincies'));
    }

    public function post_pesan(Request $request)
    {
        $layanan_id = $request->id_layanan;
        $getlayanan = DB::table('layanans')
            ->select('*')
            ->where('id_layanan', $request->id_layanan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlayanan;
        $lay1 = $objectToArray[0];
        $lay2 = (array)$lay1;
        $harga = $lay2['harga'];

        $langganan = new Langganan();
        $langganan->pelanggan_id = Auth::user()->id_user;
        $langganan->layanan_id = $layanan_id;

        $getprovinsi = DB::table('provinces')
            ->select('*')
            ->where('id', $request->id_provinsi)
            ->get()
            ->toArray();
        $objectToArray = (array)$getprovinsi;
        $prov1 = $objectToArray[0];
        $prov2 = (array)$prov1;
        $provinsi = $prov2['name'];

        $getkabupaten = DB::table('regencies')
            ->select('*')
            ->where('id', $request->id_kabupaten)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkabupaten;
        $kab1 = $objectToArray[0];
        $kab2 = (array)$kab1;
        $kabupaten = $kab2['name'];

        $getkecamatan = DB::table('districts')
            ->select('*')
            ->where('id', $request->id_kecamatan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkecamatan;
        $kec1 = $objectToArray[0];
        $kec2 = (array)$kec1;
        $kecamatan = $kec2['name'];

        $getdesa = DB::table('villages')
            ->select('*')
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

        return redirect()->route('pelanggan.langganan')
            ->with('success','Langganan berhasil ditambahkan.');
    }


    //get data for ajax
    public function get_layanan(Request $request){
        $id_kategori = $request->id_kategori;

        $layanans = DB::table('layanans')
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

        $kabupatens = DB::table('regencies')
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

        $kecamatans = DB::table('districts')
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

        $desas = DB::table('villages')
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
