<?php

namespace App\Http\Controllers;

use App\Mail\MailAdmins;
use App\Models\District;
use App\Models\Invoice;
use App\Models\Kategori;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\Layanan;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PemesananController extends Controller
{
    public function pemesanan(){
        $user = User::query()->where('user_role', '=', 3)->
        where('status', '=', '1')->get();
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

        $getpelanggan_id = User::query()
            ->where('name','=',$name)
            ->where('email','=',$email)
            ->where('username','=',$username)
            ->where('no_hp','=',$no_hp)
            ->get();

        $getemail = User::query()
            ->where('email','=',$email)
            ->get();
        $getusername = User::query()
            ->where('username','=',$username)
            ->get();

        if (count($getpelanggan_id)>0){
            return response()->json(['cek'=>0, 'msg'=>'Bukan pelanggan baru!']);
        }elseif(count($getemail)>0){
            return response()->json(['cek'=>1, 'msg'=>'Email sudah terpakai!']);
        }elseif(count($getusername)>0){
            return response()->json(['cek'=>2, 'msg'=>'Username sudah terpakai!']);
        }else{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->user_role = 3;
            $user->no_hp = $no_hp;
            $user->status = '1';
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

            $layanan_id = $request->id_layanan;
            $provinsi_id = $request->id_provinsi;
            $kabupaten_id = $request->id_kabupaten;
            $kecamatan_id = $request->id_kecamatan;
            $desa_id = $request->id_desa;
            $detail_alamat = $request->id_alamat;

            $getlayanan = Layanan::query()
                ->where('id_layanan', '=', $layanan_id)
                ->get()
                ->toArray();
            $objectToArray = (array)$getlayanan;
            $lay1 = $objectToArray[0];
            $lay2 = (array)$lay1;
            $harga = $lay2['harga'];

            $getpelanggan_id2 = User::query()
                ->where('name','=',$name)
                ->where('email','=',$email)
                ->where('username','=',$username)
                ->where('no_hp','=',$no_hp)
                ->get()
                ->toArray();
            $objectToArray = (array)$getpelanggan_id2;
            $pel1 = $objectToArray[0];
            $pel2 = (array)$pel1;
            $pelanggan_id = $pel2['id_user'];

            $langganan = new Langganan();
            $langganan->pelanggan_id = $pelanggan_id;
            $langganan->layanan_id = $layanan_id;
            $langganan->provinsi_id = $provinsi_id;
            $langganan->kabupaten_id = $kabupaten_id;
            $langganan->kecamatan_id = $kecamatan_id;
            $langganan->desa_id = $desa_id;
            $langganan->detail_alamat = $detail_alamat;

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

            $alamat = $detail_alamat;
            $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
            $langganan->alamat_pasang = implode(", ",$lengkap);
            $langganan->status = '1';
            $langganan->harga_satuan = $harga;
            $langganan->save();

            $getlangganan_id = Langganan::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('layanan_id', '=', $layanan_id)
                ->where('status', '=', '1')
                ->get()
                ->toArray();
            $objectToArray = (array)$getlangganan_id;
            $lang1 = $objectToArray[0];
            $lang2 = (array)$lang1;
            $langganan_id = $lang2['id_langganan'];

            $huruf = 'INV';
            $acak1 = rand(10, 99);
            $acak2 = rand(10, 99);
            $bulan=Carbon::now()->format('n');
            $lengkap = array($huruf,$acak1,$pelanggan_id,$acak2,$bulan);
            $id_invoice = implode($lengkap);

            $invoice = new Invoice();
            $invoice->id_invoice = $id_invoice;
            $invoice->pelanggan_id = $pelanggan_id;
            $invoice->harga_bayar = $harga;
            $invoice->bulan = $bulan;
            $invoice->status = null;
            $invoice->save();

            $langinv = new Langinv();
            $langinv->invoice_id = $id_invoice;
            $langinv->pelanggan_id = $pelanggan_id;
            $langinv->layanan_id = $layanan_id;
            $langinv->harga_satuan = $harga;
            $langinv->langganan_id = $langganan_id;
            $langinv->save();

            return redirect()->back()
                ->with('success','Langganan berhasil ditambahkan.');
        }
    }

    public function pelanggan_lama(Request $request){
        $pelanggan_id = $request->id_user;
        $layanan_id = $request->id_layanan;
        $provinsi_id = $request->id_provinsi;
        $kabupaten_id = $request->id_kabupaten;
        $kecamatan_id = $request->id_kecamatan;
        $desa_id = $request->id_desa;
        $detail_alamat = $request->id_alamat;

        $getlayanan = Layanan::query()
            ->where('id_layanan', '=', $layanan_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlayanan;
        $lay1 = $objectToArray[0];
        $lay2 = (array)$lay1;
        $harga = $lay2['harga'];

        $langganan = new Langganan();
        $langganan->pelanggan_id = $pelanggan_id;
        $langganan->layanan_id = $layanan_id;
        $langganan->provinsi_id = $provinsi_id;
        $langganan->kabupaten_id = $kabupaten_id;
        $langganan->kecamatan_id = $kecamatan_id;
        $langganan->desa_id = $desa_id;
        $langganan->detail_alamat = $detail_alamat;

        $getprovinsi = Province::query()
            ->where('id', '=', $provinsi_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getprovinsi;
        $prov1 = $objectToArray[0];
        $prov2 = (array)$prov1;
        $provinsi = $prov2['name'];

        $getkabupaten = Regency::query()
            ->where('id', '=', $kabupaten_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkabupaten;
        $kab1 = $objectToArray[0];
        $kab2 = (array)$kab1;
        $kabupaten = $kab2['name'];

        $getkecamatan = District::query()
            ->where('id', '=', $kecamatan_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkecamatan;
        $kec1 = $objectToArray[0];
        $kec2 = (array)$kec1;
        $kecamatan = $kec2['name'];

        $getdesa = Village::query()
            ->where('id', '=', $desa_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getdesa;
        $desa1 = $objectToArray[0];
        $desa2 = (array)$desa1;
        $desa = $desa2['name'];

        $alamat = $detail_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);
        $langganan->status = '1';
        $langganan->harga_satuan = $harga;
        $langganan->save();

        $getlangganan_id = Langganan::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('layanan_id', '=', $layanan_id)
            ->where('status', '=', '1')
            ->get()
            ->toArray();
        $objectToArray = (array)$getlangganan_id;
        $lang1 = $objectToArray[0];
        $lang2 = (array)$lang1;
        $langganan_id = $lang2['id_langganan'];

        $getharga = DB::table('langganans')
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('status', '1')
            ->sum('harga_satuan');

        $getinvoice = Invoice::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('status', '=', null)
            ->get()
            ->toArray();

        if (count($getinvoice)>0){
            $objectToArray = (array)$getinvoice;
            $inv1 = $objectToArray[0];
            $inv2 = (array)$inv1;
            $id_inv = $inv2['id_invoice'];
            DB::table('invoices')
                ->where('id_invoice', $id_inv)
                ->update([
                    'harga_bayar' => $getharga,
                ]);

            $langinv = new Langinv();
            $langinv->invoice_id = $id_inv;
        }else{
            $huruf = 'INV';
            $acak1 = rand(10, 99);
            $acak2 = rand(10, 99);
            $bulan=Carbon::now()->format('n');
            $lengkap = array($huruf,$acak1,$pelanggan_id,$acak2,$bulan);
            $id_invoice = implode($lengkap);

            $invoice = new Invoice();
            $invoice->id_invoice = $id_invoice;
            $invoice->pelanggan_id = $pelanggan_id;
            $invoice->harga_bayar = $getharga;
            $invoice->bulan = $bulan;
            $invoice->status = null;
            $invoice->save();

            $langinv = new Langinv();
            $langinv->invoice_id = $id_invoice;
        }
        $langinv->pelanggan_id = $pelanggan_id;
        $langinv->layanan_id = $layanan_id;
        $langinv->harga_satuan = $harga;
        $langinv->langganan_id = $langganan_id;
        $langinv->save();

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

    public function pelanggan_onprogress(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
        ]);
        $password = rand(100000, 999999);
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $no_hp = $request->no_hp;

        $getpelanggan_id = User::query()
            ->where('name','=',$name)
            ->where('email','=',$email)
            ->where('username','=',$username)
            ->where('no_hp','=',$no_hp)
            ->get();
        $getemail = User::query()
            ->where('email','=',$email)
            ->get();
        $getusername = User::query()
            ->where('username','=',$username)
            ->get();

        if (count($getpelanggan_id)>0){
            return response()->json(['cek'=>0, 'msg'=>'Bukan pelanggan baru!']);
        }elseif(count($getemail)>0){
            return response()->json(['cek'=>1, 'msg'=>'Email sudah terpakai!']);
        }elseif(count($getusername)>0){
            return response()->json(['cek'=>2, 'msg'=>'Username sudah terpakai!']);
        }else{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->user_role = 3;
            $user->no_hp = $no_hp;
            $user->status = '0';
            $user->save();

            $getpelanggan = User::query()
                ->where('name','=',$name)
                ->where('email','=',$email)
                ->where('username','=',$username)
                ->where('no_hp','=',$no_hp)
                ->get()
                ->toArray();
            $objectToArray = (array)$getpelanggan;
            $pela1 = $objectToArray[0];
            $pela2 = (array)$pela1;
            $pelanggan_id2 = $pela2['id_user'];
            $pelanggan_id = $pelanggan_id2;
        }

        $layanan_id = $request->id_layanan;
        $provinsi_id = $request->id_provinsi;
        $kabupaten_id = $request->id_kabupaten;
        $kecamatan_id = $request->id_kecamatan;
        $desa_id = $request->id_desa;
        $detail_alamat = $request->id_alamat;

        $getlayanan = Layanan::query()
            ->where('id_layanan', '=', $layanan_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlayanan;
        $lay1 = $objectToArray[0];
        $lay2 = (array)$lay1;
        $harga = $lay2['harga'];

        $langganan = new Langganan();
        $langganan->pelanggan_id = $pelanggan_id;
        $langganan->layanan_id = $layanan_id;
        $langganan->provinsi_id = $provinsi_id;
        $langganan->kabupaten_id = $kabupaten_id;
        $langganan->kecamatan_id = $kecamatan_id;
        $langganan->desa_id = $desa_id;
        $langganan->detail_alamat = $detail_alamat;

        $getprovinsi = Province::query()
            ->where('id', '=', $provinsi_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getprovinsi;
        $prov1 = $objectToArray[0];
        $prov2 = (array)$prov1;
        $provinsi = $prov2['name'];

        $getkabupaten = Regency::query()
            ->where('id', '=', $kabupaten_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkabupaten;
        $kab1 = $objectToArray[0];
        $kab2 = (array)$kab1;
        $kabupaten = $kab2['name'];

        $getkecamatan = District::query()
            ->where('id', '=', $kecamatan_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getkecamatan;
        $kec1 = $objectToArray[0];
        $kec2 = (array)$kec1;
        $kecamatan = $kec2['name'];

        $getdesa = Village::query()
            ->where('id', '=', $desa_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getdesa;
        $desa1 = $objectToArray[0];
        $desa2 = (array)$desa1;
        $desa = $desa2['name'];

        $alamat = $detail_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);
        $langganan->status = '3';
        $langganan->harga_satuan = $harga;
        $langganan->save();

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

    public function setujui_pesan($id_langganan){
        $getlang = Langganan::query()->find($id_langganan);
        $getlang->status = '1';
        $getlang->save();

        $layanan_id = $getlang->layanan_id;
        $harga = $getlang->harga_satuan;
        $pelanggan_id = $getlang->pelanggan_id;

        $getpel = User::query()->find($pelanggan_id);
        $name = $getpel->name;
        $username = $getpel->username;
        $email = $getpel->email;
        $pass = $getpel->password;
        $nama_role = 'Pelanggan';

        $password = Hash::make($pass);
        $getpel->password = $password;
        $getpel->status = '1';
        $getpel->save();

        $data_ambil = [
            'nama' => $name,
            'nama_role' => $nama_role,
            'username' => $username,
            'email' => $email,
            'password' => $pass,
        ];

        Mail::to($email)->send(new MailAdmins($data_ambil));

//        dd($pelanggan_id, $harga, $layanan_id);
        $getharga = DB::table('langganans')
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('status', '1')
            ->sum('harga_satuan');

        $getinvoice = Invoice::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('status', '=', null)
            ->get()
            ->toArray();

        if (count($getinvoice)>0){
            $objectToArray = (array)$getinvoice;
            $inv1 = $objectToArray[0];
            $inv2 = (array)$inv1;
            $id_inv = $inv2['id_invoice'];
            DB::table('invoices')
                ->where('id_invoice', $id_inv)
                ->update([
                    'harga_bayar' => $getharga,
                ]);

            $langinv = new Langinv();
            $langinv->invoice_id = $id_inv;
        }else{
            $huruf = 'INV';
            $acak1 = rand(10, 99);
            $acak2 = rand(10, 99);
            $bulan=Carbon::now()->format('n');
            $lengkap = array($huruf,$acak1,$pelanggan_id,$acak2,$bulan);
            $id_invoice = implode($lengkap);

            $invoice = new Invoice();
            $invoice->id_invoice = $id_invoice;
            $invoice->pelanggan_id = $pelanggan_id;
            $invoice->harga_bayar = $getharga;
            $invoice->bulan = $bulan;
            $invoice->status = null;
            $invoice->save();

            $langinv = new Langinv();
            $langinv->invoice_id = $id_invoice;
        }
        $langinv->pelanggan_id = $pelanggan_id;
        $langinv->layanan_id = $layanan_id;
        $langinv->harga_satuan = $harga;
        $langinv->langganan_id = $id_langganan;
        $langinv->save();

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
