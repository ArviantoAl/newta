<?php

namespace App\Http\Controllers;

use App\Mail\Invoice;
use App\Models\Bts;
use App\Models\Invoice as Invoices;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\Layanan;
use App\Models\ProfilCv;
use App\Models\TurunanBts;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function data_invoice(){
        if(auth()->user()->user_role==3){
            $user = Auth::user()->id_user;
            $invoices = Invoices::query()->where('pelanggan_id', $user)->paginate(10);
        }else{
            $invoices = Invoices::query()->paginate(10);
        }
        $tanggal = Carbon::now()->setTimezone('Asia/Jakarta');
        $langganan = Langinv::all();

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'tanggal'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.teknisi.invoice', compact('invoices', 'tanggal'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'tanggal'));
        }
    }

    public function kirim_semua(){
        $bulan=Carbon::now()->subMonth()->format('n');
        $bulans=Carbon::now()->format('n');

        $datas = Invoices::query()
            ->where('bulan', '=', $bulan)
            ->where('status_id', '=', 8)
            ->get();
//dd($bulan);
//        $datainv = [];
        foreach($datas as $data){
            $pelanggan_id = $data->pelanggan_id;
//            $harga_bayar = $data->harga_bayar;
            $id_invoice = $data->id_invoice;
            $ppn = $data->ppn;

            $gettagihan = DB::table('langganan_invoices')
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('invoice_id', '=', $id_invoice)
                ->where('status_id', '=', 8)
                ->sum('harga_satuan');

            if ($ppn == 1){
                $getppn = ProfilCv::query()->find(1);
                $hppn = $getppn->ppn;
                $hargappn = $gettagihan*$hppn/100;
                $hgettagihan = $gettagihan+$hargappn;
                $hargatagihan = $hgettagihan;
            }else{
                $hargatagihan = $hgettagihan;
            }

            $user = User::find($pelanggan_id);
            $nama_pelanggan = $user->name;
            $username_pelanggan = $user->username;
            $email_pelanggan = $user->email;

            $langganans = Langinv::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('invoice_id', '=', $id_invoice)
                ->where('status_id', '=', 8)
                ->get();

            $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');
//            $tgl_tempo = Carbon::now()->setTimezone('Asia/Jakarta')->addMonth();

            $data_ambil = [
                'email_cv' => 'info@gudangtechno.web.id',
                'nama_pelanggan' => $nama_pelanggan,
                'email_pelanggan' => $email_pelanggan,
                'no_hp_pelanggan' => $username_pelanggan,
                'id_invoice' => $id_invoice,
                'tgl_terbit' => $tgl_terbit,
//                'tgl_tempo' => $tgl_tempo,
                'harga_bayar' => $hargatagihan,
                'langganans' => $langganans,
            ];

            Mail::to($email_pelanggan)->send(new Invoice($data_ambil));
            DB::table('langganans')
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('status_id', '=', 3)
                ->update([
                    'status_id'=>2,
                    'tgl_aktif' => null,
                ]);
            DB::table('langganan_invoices')
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('invoice_id', '=', $id_invoice)
                ->where('status_id', '=', 8)
                ->update([
                    'status_id'=>6,
                ]);
            DB::table('invoices')
                ->where('id_invoice', '=', $id_invoice)
                ->where('bulan', '=', $bulan)
                ->update([
                    'status_id'=>6,
                    'tagihan' => $hargatagihan,
                    'bulan'=>$bulans
                ]);
        }
        return back()->with('success', 'Invoice telah terkirim semua!');

    }

    public function setujui_pembayaran($id_invoice)
    {
        $invoices = Invoices::query()->find($id_invoice);
        $id_pelanggan = $invoices->pelanggan_id;
        $user = User::query()->find($id_pelanggan);
        $nama2 = $user->name;

        $invoices->status_id = 8;
        $invoices->tagihan = 0;
        $invoices->save();

        $tgl_aktif = Carbon::now()->setTimezone('Asia/Jakarta');

        $datas = Langganan::query()->where('pelanggan_id', '=', $id_pelanggan)
            ->where('status_id', '=', 2)
            ->get();

        $nnama = [];
        foreach($datas as $data){
            $desa = $data->desa_id;
            $kecamatan = $data->kecamatan_id;
            $kabupaten = $data->kabupaten_id;
            $provinsi = $data->provinsi_id;
            $detail_alamat = $data->detail_alamat;
            $alamat_pasang = $data->alamat_pasang;
            $layanan = $data->layanan_id;
            $bts_id = $data->bts_id;
            $ip = $data->ip;

            $getbts = Bts::query()->find($bts_id);
            $frekuensi = $getbts->frekuensi;

            $getdesa = Village::query()->find($desa);
            $nama3 = $getdesa->name;

            $getlayanan = Layanan::query()->find($layanan);
            $nama4 = $getlayanan->nama_layanan;

            $arrnama = array($nama2,$nama3,$nama4);
            $nama = implode("-",$arrnama);
            $ssid = implode("_",$arrnama);

            $tbts = new TurunanBts();
            $tbts->bts_id = $bts_id;
            $tbts->nama_turunan = $nama;
            $tbts->ssid = $ssid;
            $tbts->provinsi_id = $provinsi;
            $tbts->kabupaten_id = $kabupaten;
            $tbts->kecamatan_id = $kecamatan;
            $tbts->desa_id = $desa;
            $tbts->detail_alamat = $detail_alamat;
            $tbts->alamat_pasang = $alamat_pasang;
            $tbts->frekuensi = $frekuensi;
            $tbts->ip = $ip;
            $tbts->status_id = 2;

            $tbts->save();
//            $nnama[]=$nama;
        }

        DB::table('langganans')
            ->where('pelanggan_id', '=', $id_pelanggan)
            ->where('status_id', '=', 2)
            ->update([
                'status_id'=>3,
                'tgl_aktif' => $tgl_aktif,
            ]);
        DB::table('langganan_invoices')
            ->where('pelanggan_id', '=', $id_pelanggan)
            ->where('invoice_id', '=', $id_invoice)
            ->where('status_id', '=', 7)
            ->update([
                'status_id'=>8,
            ]);
//dd($nnama);
        return redirect()->route('admin.invoice');
    }

    public function tolak_pembayaran($id_invoice)
    {
        $invoices = Invoices::query()->find($id_invoice);
        $id_pelanggan = $invoices->pelanggan_id;

        $invoices->status_id = 9;
        $invoices->tagihan = 0;
        $invoices->harga_bayar = 0;
        $invoices->save();

        $tgl_aktif = Carbon::now()->setTimezone('Asia/Jakarta');

        $datas = Langganan::query()->where('pelanggan_id', '=', $id_pelanggan)
            ->where('status_id', '=', 2)
            ->get();

        $nnama = [];

        DB::table('langganans')
            ->where('pelanggan_id', '=', $id_pelanggan)
            ->where('status_id', '=', 2)
            ->update([
                'status_id'=>4,
                'tgl_aktif' => $tgl_aktif,
            ]);
        DB::table('langganan_invoices')
            ->where('pelanggan_id', '=', $id_pelanggan)
            ->where('invoice_id', '=', $id_invoice)
            ->where('status_id', '=', 7)
            ->update([
                'status_id'=>9,
            ]);
//dd($nnama);
        return redirect()->route('admin.invoice');
    }

    public function print_invoice($id_invoice){
        $invoice = Invoices::find($id_invoice);

        $pelanggan_id = $invoice->pelanggan_id;
        $tgl_terbit = $invoice->tgl_terbit;
        $tgl_tempo = $invoice->tgl_tempo;
        $harga_inv = $invoice->harga_bayar;
        $status_inv = $invoice->status;

        $user = User::find($pelanggan_id);
        $nama_pelanggan = $user->name;
        $email_pelanggan = $user->email;
        $no_hp_pelanggan = $user->no_hp;
        $alamat_pelanggan = $user->alamat;

        $getharga = DB::table('langganan_invoices')
            ->where('invoice_id', $id_invoice)
            ->where('pelanggan_id', $pelanggan_id)
            ->sum('harga_satuan');

        if ($status_inv=='1'){
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $harga_bayar = $getharga;
            $status = 'Belum Dibayar';
        }elseif ($status_inv=='2'){
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $harga_bayar = $getharga;
            $status = 'Lunas';
        }elseif ($status_inv==null){
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $harga_bayar = $getharga;
            $status = 'Belum Dikirim';
        }elseif ($status_inv=='0') {
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $harga_bayar = $getharga;
            $status = 'Tidak Disetujui';
        }

        $data_print = [
            'status' => $status,
            'id_invoice' => $id_invoice,
            'tgl_terbit' => $tgl_terbit,
            'tgl_tempo' => $tgl_tempo,
            'harga_bayar' => $harga_bayar,
            'nama_pelanggan' => $nama_pelanggan,
            'email_pelanggan' => $email_pelanggan,
            'no_hp_pelanggan' => $no_hp_pelanggan,
            'alamat_pelanggan' => $alamat_pelanggan,
            'langganans' => $langganans,
            'email_cv' => 'info@gudangtechno.web.id',
        ];

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.print.invoice', compact('data_print'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.teknisi.print.invoice', compact('data_print'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.print_invoice', compact('data_print'));
        }
    }

    public function bukti(Request $request, $id_inv){
        $request->validate([
            'bukti' => 'mimes:jpeg,png,bmp,tiff |max:4096',
        ]);
        $bukti = $request->file('bukti');
        $name1 = $bukti->getClientOriginalName();

        $lengkap = array($id_inv,$name1);
        $name = implode($lengkap);

        $invoice = Invoices::find($id_inv);
        $invoice->bukti_bayar = $name;
        $invoice->status_id = 7;
        $invoice->save();

        DB::table('langganan_invoices')
            ->where('invoice_id', '=', $id_inv)
            ->where('status_id', '=', 6)
            ->update([
                'status_id'=>7,
            ]);

        $bukti->move(public_path('bukti_bayar'), $name);
        return redirect()->back();
    }

    //get ajax
    public function get_detail(Request $request)
    {
        $id_invoice = $request->id_invoice;

        $langganans = Langinv::query()
            ->where('invoice_id', '=', $id_invoice)
            ->get();

        $td = "<table class='table table-bordered table-striped mg-b-0 text-md-nowrap'>";
        foreach ($langganans as $langganan) {
            $td .= "<td>$langganan->invoice_id</td>";
            $td .= "<td>$langganan->langganan_id</td>";
        }
        echo $td;
    }
}
