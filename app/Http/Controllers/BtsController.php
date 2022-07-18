<?php

namespace App\Http\Controllers;

use App\Models\Bts;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\JenisBts;
use App\Models\Layanan;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\village;
use App\Models\Langganan;
use App\Models\TurunanBts;
use Illuminate\Support\Facades\DB;

    
class BtsController extends Controller
{

    public function index_frekuensi(){
        $kategoris = Kategori::all();

        return view('dashboard.teknisi.masterdata.masterfrekuensi', compact('kategoris'));
    }


    //all about kategori
    public function index_kategori(){
        $jenis = JenisBts::all();

        return view('dashboard.teknisi.masterdata.masterkategori', compact('jenis'));
        
    }
    public function tambah_kategori(){
        $jenis_bts = new JenisBts();

        return view('dashboard.admin.layanan.tambah_layanan', compact('jenis_bts'));
    }
    public function get_tambah_kategori()
    {
        return view('dashboard.teknisi.masterdata.tambahmasterkategori');
    }
    public function post_tambah_kategori(Request $request){
        $request->validate([
            'nama_perangkat' => 'required',
        ]);

        JenisBts::create([
            'nama_perangkat' => request('nama_perangkat'),
        ]);

        return redirect()->back()
            ->with('success','Kategori berhasil ditambahkan.');
    }


    //all about bts
    public function index_bts(){
        $bts = Bts::all();

        return view('dashboard.teknisi.masterdata.masterbts', compact('bts'));
    }

    public function tambah_bts(){
        $bts = new bts();
        $provinsi = Province::all();
        $kabupaten = regency::all();
        $kecamatan = District::all();
        $desa = village::all();
        // $getprovinsi = Province::query()->find($provinsi_id);
        // $provinsi = $getprovinsi->name;

        // $getkabupaten = Regency::query()->find($kabupaten_id);
        // $kabupaten = $getkabupaten->name;

        // $getkecamatan = District::query()->find($kecamatan_id);
        // $kecamatan = $getkecamatan->name;

        // $getdesa = Village::query()->find($desa_id);
        // $desa = $getdesa->name;
        return view('dashboard.teknisi.masterdata.tambahmasterbts', compact('bts','provinsi','kabupaten','kecamatan','desa'));
    }
    // public function get_tambah_bts()
    // {
    //     return view('dashboard.teknisi.masterdata.tambahmasterbts');
    // }
    public function post_tambah_bts(Request $request){
        $request->validate([
            'nama_bts' => 'required',
            'frekkuensi' => 'required',
            'ssid' => 'required',
            'ip' => 'required',
        ]);

        JenisBts::create([
            'nama_bts' => request('nama_bts'),
            'provinsi_id' => request('provinsi_id'),
            'kabupaten_id' => request('kabupaten_id'),
            'kecamatan_id' => request('kecamatan_id'),
            'desa_id' => request('desa_id'),
            'detail_alamat' => request('detail_alamat'),
            'alamat_pasang' => request('alamat_pasang'),
            'frekuensi' => request('frekuensi'),
            'ssid' => request('ssid'),
            'ip' => request('ip'),
            'lokasi' => request('lokasi'),
            'status_id' => request('status_id'),
        ]);

        return redirect()->back()
            ->with('success','Bts berhasil ditambahkan.');
    }

    //all about perangkat
    // public function index_perangkat(){
    //     $jenis = JenisPerangkat::all();

    //     return view('dashboard.teknisi.perangkat', compact('perangkat'));
        
    // }

    //all about pelanggan
    public function index_pelanggan(){
        $turunan_bts = TurunanBts::all();

        return view('dashboard.teknisi.pelanggan', compact('turunan_bts'));
        
    }

    public function get_tambah_pelanggan(){
        $turunan_bts = new TurunanBts();

        return view('dashboard.teknisi.tambahpelanggan', compact('turunan_bts'));
    }

    public function post_tambah_pelanggan(){
        $turunan_bts = new TurunanBts();

        return view('dashboard.teknisi.tambahpelanggan', compact('turunan_bts'));
    }


};
