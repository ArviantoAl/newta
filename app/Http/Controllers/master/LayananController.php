<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public function index_kategori(){
        $kategoris = Kategori::orderBy('nama_kategori', 'ASC')
            ->get();

        return view('dashboard.admin.layanan.kategori', compact('kategoris'));
    }

    public function index_layanan(){
        $kategoris = Kategori::all();
        $layanans = Layanan::all();

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.layanan.layanan', compact('kategoris', 'layanans'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.layanan.layanan', compact('kategoris', 'layanans'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.keuangan.layanan', compact('kategoris', 'layanans'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.layanan', compact('kategoris', 'layanans'));
        }

    }

    public function tambah_kategori(){
        $kategori = new Kategori();
        return view('dashboard.admin.layanan.tambah_kategori', compact('kategori'));
    }

    public function post_tambah_kategori(Request $request){
        $request->validate([
            'nama_kategori' => 'required',
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;

        $kategori->save();

        return redirect()->route('admin.kategori')
            ->with('success','Kategori berhasil ditambahkan.');
    }

    public function destroy($id_kategori)
    {
        $kategoris = Kategori::find($id_kategori);
        $layanans = Layanan::where('layanan_kategori', $id_kategori);

        $layanans->delete();
        $kategoris->delete();

        return redirect()->route('admin.kategori')
            ->with('success','Kategori berhasil dihapus.');
    }

    public function tambah_layanan(){
        $kategoris = Kategori::all();
        $layanan = new Layanan();

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.layanan.tambah_layanan', compact('kategoris', 'layanan'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.layanan.tambah_layanan', compact('kategoris', 'layanan'));
        }
    }

    public function post_tambah_layanan(Request $request){
        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required',
            'layanan_kategori' => 'required',
        ]);

        $layanan = new Layanan();
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga = $request->harga;
        $layanan->layanan_kategori = $request->layanan_kategori;

        $layanan->save();

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.layanan')
                ->with('success','Layanan berhasil ditambahkan.');
        }elseif(auth()->user()->user_role==2){
            return redirect()->route('administrator.layanan')
                ->with('success','Layanan berhasil ditambahkan.');
        }
    }

    public function edit_layanan($id_layanan){
        $kategoris = Kategori::all();
        $layanan = Layanan::find($id_layanan);
        $kategorilayanan = $layanan->layanan_kategori;

        $get_kategori = DB::table('kategoris')
            ->select('*')
            ->where('id_kategori', $kategorilayanan)
            ->get()
            ->toArray();
        $objectToArray = (array)$get_kategori;
        $kat1 = $objectToArray[0];
        $kat2 = (array)$kat1;
        $nama_kategori = $kat2['nama_kategori'];
        $id_kategori = $kat2['id_kategori'];

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.layanan.edit_layanan', compact('kategoris', 'layanan', 'nama_kategori', 'id_kategori'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.layanan.edit_layanan', compact('kategoris', 'layanan', 'nama_kategori', 'id_kategori'));
        }
    }

    public function post_edit_layanan(Request $request ,$id_layanan){
        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required',
            'layanan_kategori' => 'required',
        ]);

        $layanan = Layanan::find($id_layanan);
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga = $request->harga;
        $layanan->layanan_kategori = $request->layanan_kategori;

        $layanan->save();

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.layanan')
                ->with('success','Layanan berhasil diubah.');
        }elseif(auth()->user()->user_role==2){
            return redirect()->route('administrator.layanan')
                ->with('success','Layanan berhasil diubah.');
        }
    }

    public function destroy_layanan($id_layanan)
    {
        $layanans = Layanan::find($id_layanan);
        $layanans->delete();

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.layanan')
                ->with('success','Layanan berhasil dihapus.');
        }elseif(auth()->user()->user_role==2){
            return redirect()->route('administrator.layanan')
                ->with('success','Layanan berhasil dihapus.');
        }
    }
}
