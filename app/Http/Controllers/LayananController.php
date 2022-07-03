<?php

namespace App\Http\Controllers;

use App\Models\Bts;
use App\Models\Kategori;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public function index_kategori(){
        $kategoris = Kategori::query()->orderBy('nama_kategori', 'ASC')
            ->paginate(10);

        return view('dashboard.admin.layanan.kategori', compact('kategoris'));
    }

    public function index_layanan(){
        $kategoris = Kategori::all();
        $layanans = Layanan::query()->paginate(10);

        return view('dashboard.admin.layanan.layanan', compact('kategoris', 'layanans'));
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
        $btss = Bts::all();
        $layanan = new Layanan();

        return view('dashboard.admin.layanan.tambah_layanan', compact('kategoris', 'layanan', 'btss'));
    }

    public function post_tambah_layanan(Request $request){
        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required',
            'layanan_kategori' => 'required',
            'bts_id' => 'required',
        ]);

        $layanan = new Layanan();
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga = $request->harga;
        $layanan->layanan_kategori = $request->layanan_kategori;
        $layanan->bts_id = $request->bts_id;

        $layanan->save();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil ditambahkan.');
    }

    public function edit_layanan($id_layanan){
        $kategoris = Kategori::all();
        $btss = Bts::all();
        $layanan = Layanan::find($id_layanan);

        return view('dashboard.admin.layanan.edit_layanan', compact('kategoris', 'layanan', 'btss'));
    }

    public function post_edit_layanan(Request $request ,$id_layanan){
        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required',
            'layanan_kategori' => 'required',
            'bts_id' => 'required',
        ]);

        $layanan = Layanan::find($id_layanan);
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga = $request->harga;
        $layanan->layanan_kategori = $request->layanan_kategori;
        $layanan->bts_id = $request->bts_id;

        $layanan->save();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil diubah.');
    }

    public function destroy_layanan($id_layanan)
    {
        $layanans = Layanan::find($id_layanan);
        $layanans->delete();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil dihapus.');
    }
}
