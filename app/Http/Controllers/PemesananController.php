<?php

namespace App\Http\Controllers;

use App\Mail\MailAdmins;
use App\Mail\Invoice as Invoices;
use App\Models\Bts;
use App\Models\District;
use App\Models\Invoice;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\Layanan;
use App\Models\ProfilCv;
use App\Models\Province;
use App\Models\Regency;
use App\Models\TurunanBts;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PemesananController extends Controller
{
    public function pemesanan(){
        $user = User::query()->where('user_role', '=', 3)
            ->where('status_id', '=', 3)
            ->orWhere('status_id', '=', 2)
            ->get();
        $layanan = Layanan::all();
        $provinsi = Province::all();
        $bts = Bts::query()->where('status_id', '=', 3)->get();
//        $turunan = Bts::query()->where('turunan', '!=', null )
//            ->where('level', '=', null)->get();

//        dd($kategori);
        return view('dashboard.admin.pemesanan.pemesanan', compact('user', 'layanan', 'provinsi', 'bts'));
    }

    public function pelanggan_baru(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);
        $pass = rand(100000, 999999);
        $password = Hash::make($pass);
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;

        $getpelanggan_id = User::query()
            ->where('name','=',$name)
            ->where('email','=',$email)
            ->where('username','=',$username)
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
            return response()->json(['cek'=>2, 'msg'=>'No Hp sudah terpakai!']);
        }else{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->user_role = 3;
            $user->status_id = 2;
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
            $bts_id = $request->id_bts;
            $getturunan = $request->id_turunan;
            if ($getturunan==0){
                $turunan_id = null;
            }else{
                $turunan_id = $getturunan;
            }
            $ip = $request->ip;
            $ip_radio = $request->ip_radio;

            $getlayanan = Layanan::query()->find($layanan_id);
            $harga = $getlayanan->harga;

            $getpelanggan_id2 = User::query()
                ->where('name','=',$name)
                ->where('email','=',$email)
                ->where('username','=',$username)
                ->where('status_id', '=', 2)
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
            $langganan->bts_id = $bts_id;
            $langganan->turunan_id = $turunan_id;
            $langganan->ip = $ip;
            $langganan->ip_radio = $ip_radio;

            $getprovinsi = Province::query()->find($provinsi_id);
            $provinsi = $getprovinsi->name;

            $getkabupaten = Regency::query()->find($kabupaten_id);
            $kabupaten = $getkabupaten->name;

            $getkecamatan = District::query()->find($kecamatan_id);
            $kecamatan = $getkecamatan->name;

            $getdesa = Village::query()->find($desa_id);
            $desa = $getdesa->name;

            $alamat = $detail_alamat;
            $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
            $langganan->alamat_pasang = implode(", ",$lengkap);
            $langganan->status_id = 2;
            $langganan->save();

            $getlangganan_id = Langganan::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('layanan_id', '=', $layanan_id)
                ->where('ip', '=', $ip)
                ->where('ip_radio', '=', $ip_radio)
                ->where('status_id', '=', 2)
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

            $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');

            $getppn = ProfilCv::query()->find(1);
            $ppn = $getppn->ppn;
            $hargappn = $harga*$ppn/100;
            $harga2 = $harga+$hargappn;

            $invoice = new Invoice();
            $invoice->id_invoice = $id_invoice;
            $invoice->pelanggan_id = $pelanggan_id;
            $invoice->harga_bayar = $harga2;
            $invoice->tagihan = $harga2;
            $invoice->tgl_terbit = $tgl_terbit;
            $invoice->bulan = $bulan;
            $invoice->ppn = 1;
            $invoice->status_id = 6;
            $invoice->save();

            $langinv = new Langinv();
            $langinv->invoice_id = $id_invoice;
            $langinv->pelanggan_id = $pelanggan_id;
            $langinv->layanan_id = $layanan_id;
            $langinv->harga_satuan = $harga;
            $langinv->langganan_id = $langganan_id;
            $langinv->status_id = 6;
            $langinv->save();

            $langganans = Langinv::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('invoice_id', '=', $id_invoice)
                ->where('status_id', '=', 6)
                ->get();

            $data_ambil = [
                'email_cv' => 'info@gudangtechno.web.id',
                'nama_pelanggan' => $name,
                'email_pelanggan' => $email,
                'no_hp_pelanggan' => $username,
                'id_invoice' => $id_invoice,
                'tgl_terbit' => $tgl_terbit,
                'harga_bayar' => $harga2,
                'langganans' => $langganans,
            ];

            Mail::to($email)->send(new Invoices($data_ambil));

            return redirect()->route('admin.invoice')
                ->with('success','Invoice Terkirim.');
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
        $bts_id = $request->id_bts;
        $getturunan = $request->id_turunan;
        if ($getturunan==0){
            $turunan_id = null;
        }else{
            $turunan_id = $getturunan;
        }
        $ip = $request->ip;
        $ip_radio = $request->ip_radio;

        $getlayanan = Layanan::query()->find($layanan_id);
        $harga = $getlayanan->harga;

        $langganan = new Langganan();
        $langganan->pelanggan_id = $pelanggan_id;
        $langganan->layanan_id = $layanan_id;
        $langganan->provinsi_id = $provinsi_id;
        $langganan->kabupaten_id = $kabupaten_id;
        $langganan->kecamatan_id = $kecamatan_id;
        $langganan->desa_id = $desa_id;
        $langganan->detail_alamat = $detail_alamat;
        $langganan->bts_id = $bts_id;
        $langganan->turunan_id = $turunan_id;
        $langganan->ip = $ip;
        $langganan->ip_radio = $ip_radio;

        $getprovinsi = Province::query()->find($provinsi_id);
        $provinsi = $getprovinsi->name;

        $getkabupaten = Regency::query()->find($kabupaten_id);
        $kabupaten = $getkabupaten->name;

        $getkecamatan = District::query()->find($kecamatan_id);
        $kecamatan = $getkecamatan->name;

        $getdesa = Village::query()->find($desa_id);
        $desa = $getdesa->name;

        $alamat = $detail_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);
        $langganan->status_id = 2;
        $langganan->save();

        $getlangganan_id = Langganan::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('layanan_id', '=', $layanan_id)
            ->where('ip', '=', $ip)
            ->where('ip_radio', '=', $ip_radio)
            ->where('status_id', '=', 2)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlangganan_id;
        $lang1 = $objectToArray[0];
        $lang2 = (array)$lang1;
        $langganan_id = $lang2['id_langganan'];

        $getinvoice = Invoice::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->get()
            ->toArray();
        $objectToArray = (array)$getinvoice;
        $inv1 = $objectToArray[0];
        $inv2 = (array)$inv1;
        $id_inv = $inv2['id_invoice'];

        $langinv = new Langinv();
        $langinv->invoice_id = $id_inv;
        $langinv->pelanggan_id = $pelanggan_id;
        $langinv->layanan_id = $layanan_id;
        $langinv->harga_satuan = $harga;
        $langinv->langganan_id = $langganan_id;
        $langinv->status_id = 6;
        $langinv->save();

        $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');

        $gettotal = DB::table('langganan_invoices')
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('invoice_id', '=', $id_inv)
            ->where('status_id', '=', 6)
            ->orWhere('status_id', '=', 7)
            ->orWhere('status_id', '=', 8)
            ->sum('harga_satuan');

        $gettagihan = DB::table('langganan_invoices')
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('invoice_id', '=', $id_inv)
            ->where('status_id', '=', 6)
            ->sum('harga_satuan');

        $getppn = ProfilCv::query()->find(1);
        $ppn = $getppn->ppn;
        $hargappn = $gettotal*$ppn/100;
        $hargappn2 = $gettagihan*$ppn/100;
        $hgettotal = $gettotal+$hargappn;
        $hgettagihan = $gettagihan+$hargappn2;

        DB::table('invoices')
            ->where('id_invoice', $id_inv)
            ->update([
                'harga_bayar' => $hgettotal,
                'tagihan' => $hgettagihan,
                'tgl_terbit' => $tgl_terbit,
                'tgl_tempo' => null,
                'status_id' => 6
            ]);

        $user = User::query()->find($pelanggan_id);
        $name = $user->name;
        $email = $user->email;
        $username = $user->username;

        $langganans = Langinv::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('invoice_id', '=', $id_inv)
            ->get();

        $data_ambil = [
            'email_cv' => 'info@gudangtechno.web.id',
            'nama_pelanggan' => $name,
            'email_pelanggan' => $email,
            'no_hp_pelanggan' => $username,
            'id_invoice' => $id_inv,
            'tgl_terbit' => $tgl_terbit,
            'harga_bayar' => $hgettagihan,
            'langganans' => $langganans,
        ];

        Mail::to($email)->send(new Invoices($data_ambil));

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

    public function pelanggan_onprogress(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
        ]);
        $password = rand(100000, 999999);
        $name = $request->name;
        $username = $request->username;
        $rn = rand(100000, 999999);

        $rml = "@onprogress.com";
        $eml = array($name,$rn,$rml);
        $email = implode($eml);

        $getpelanggan_id = User::query()
            ->where('name','=',$name)
            ->where('username','=',$username)
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
            return response()->json(['cek'=>2, 'msg'=>'No Hp sudah terpakai!']);
        }else{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->user_role = 3;
            $user->status_id = 1;
            $user->save();

            $getpelanggan = User::query()
                ->where('name','=',$name)
                ->where('email','=',$email)
                ->where('username','=',$username)
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

        $langganan = new Langganan();
        $langganan->pelanggan_id = $pelanggan_id;
        $langganan->layanan_id = $layanan_id;
        $langganan->provinsi_id = $provinsi_id;
        $langganan->kabupaten_id = $kabupaten_id;
        $langganan->kecamatan_id = $kecamatan_id;
        $langganan->desa_id = $desa_id;
        $langganan->detail_alamat = $detail_alamat;

        $getprovinsi = Province::query()->find($provinsi_id);
        $provinsi = $getprovinsi->name;

        $getkabupaten = Regency::query()->find($kabupaten_id);
        $kabupaten = $getkabupaten->name;

        $getkecamatan = District::query()->find($kecamatan_id);
        $kecamatan = $getkecamatan->name;

        $getdesa = Village::query()->find($desa_id);
        $desa = $getdesa->name;

        $alamat = $detail_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);
        $langganan->status_id = 1;
        $langganan->save();

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

    public function setujui_pesan($id_langganan){
        $get_lang = Langganan::query()->find($id_langganan);
        $pelanggan_id = $get_lang->pelanggan_id;
        $user = User::query()->find($pelanggan_id);
        $bts = Bts::all();
        return view('dashboard.admin.pemesanan.approve', compact('get_lang', 'bts', 'user'));
    }

    public function post_setujui_pesan(Request $request, $id_langganan){
        $email2 = $request->email;
        $bts_id = $request->id_bts;
        $getturunan = $request->id_turunan;
        if ($getturunan==0){
            $turunan_id = null;
        }else{
            $turunan_id = $getturunan;
        }
        $ip = $request->ip;
        $ip_radio = $request->ip_radio;

        $getemail = User::query()
            ->where('email','=',$email2)
            ->get();

        if(count($getemail)>0){
            return response()->json(['cek'=>1, 'msg'=>'Email sudah terpakai!']);
        }else{
            $getlang = Langganan::query()->find($id_langganan);
            $getlang->bts_id = $bts_id;
            $getlang->turunan_id = $turunan_id;
            $getlang->ip = $ip;
            $getlang->ip_radio = $ip_radio;
            $getlang->status_id = 2;
            $getlang->save();

            $layanan_id = $getlang->layanan_id;
            $pelanggan_id = $getlang->pelanggan_id;

            $getpel = User::query()->find($pelanggan_id);
            $name = $getpel->name;
            $username = $getpel->username;
            $email = $email2;
            $pass = $getpel->password;
            $nama_role = 'Pelanggan';

            $password = Hash::make($pass);
            $getpel->password = $password;
            $getpel->status_id = 2;
            $getpel->email = $email;
            $getpel->save();
        }

        $data_ambil = [
            'nama' => $name,
            'nama_role' => $nama_role,
            'username' => $username,
            'email' => $email,
            'password' => $pass,
        ];

        Mail::to($email)->send(new MailAdmins($data_ambil));

        $getlayanan = Layanan::query()->find($layanan_id);
        $harga = $getlayanan->harga;

        $huruf = 'INV';
        $acak1 = rand(10, 99);
        $acak2 = rand(10, 99);
        $bulan=Carbon::now()->format('n');
        $lengkap = array($huruf,$acak1,$pelanggan_id,$acak2,$bulan);
        $id_invoice = implode($lengkap);

        $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');

        $getppn = ProfilCv::query()->find(1);
        $ppn = $getppn->ppn;
        $hargappn = $harga*$ppn/100;
        $harga2 = $harga+$hargappn;

        $invoice = new Invoice();
        $invoice->id_invoice = $id_invoice;
        $invoice->pelanggan_id = $pelanggan_id;
        $invoice->harga_bayar = $harga2;
        $invoice->tagihan = $harga2;
        $invoice->tgl_terbit = $tgl_terbit;
        $invoice->bulan = $bulan;
        $invoice->ppn = 1;
        $invoice->status_id = 6;
        $invoice->save();

        $langinv = new Langinv();
        $langinv->invoice_id = $id_invoice;
        $langinv->pelanggan_id = $pelanggan_id;
        $langinv->layanan_id = $layanan_id;
        $langinv->harga_satuan = $harga;
        $langinv->langganan_id = $id_langganan;
        $langinv->status_id = 6;
        $langinv->save();

        $langganans = Langinv::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('invoice_id', '=', $id_invoice)
            ->where('status_id', '=', 6)
            ->get();

        $data_ambil = [
            'email_cv' => 'info@gudangtechno.web.id',
            'nama_pelanggan' => $name,
            'email_pelanggan' => $email,
            'no_hp_pelanggan' => $username,
            'id_invoice' => $id_invoice,
            'tgl_terbit' => $tgl_terbit,
            'harga_bayar' => $harga2,
            'langganans' => $langganans,
        ];

        Mail::to($email)->send(new Invoices($data_ambil));
    }

    public function tolak_langganan($id_langganan){
        $langganan = Langganan::find($id_langganan);

        $langganan->status_id = 5;
        $langganan->save();

        return redirect()->route('admin.langganan')
            ->with('success','Status Langganan berhasil diubah.');
    }

//    get from ajax
    public function get_turunan(Request $request)
    {
        $id_bts = $request->id_bts;

        $turunans = TurunanBts::query()
            ->where('bts_id', '=', $id_bts)
            ->where('status_id', '=', 4)->get();

        $option = "<option value='0'>Pilih Pelanggan</option>";
        foreach ($turunans as $turunan) {
            $option .= "<option value='$turunan->id_turunan'>$turunan->nama_turunan</option>";
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
