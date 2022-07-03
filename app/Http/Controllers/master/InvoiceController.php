<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Mail\Invoice;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\User;
use App\Models\Invoice as Invoices;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function kirim_invoice($id_invoice){
        $data = DB::table('invoices')
            ->select('*')
            ->where('id_invoice', $id_invoice)
            ->get()
            ->toArray();
        $objectToArray = (array)$data;
        $data1 = $objectToArray[0];
        $data2 = (array)$data1;
        $getpelanggan = $data2['pelanggan_id'];
        $harga_bayar = $data2['harga_bayar'];

        $user = User::find($getpelanggan);
        $nama_pelanggan = $user->name;
        $email_pelanggan = $user->email;
        $no_hp_pelanggan = $user->no_hp;
        $alamat_pelanggan = $user->alamat;

        DB::table('langganans')
            ->where('pelanggan_id', $getpelanggan)
            ->where('status', '2')
            ->update([
                'status'=>'3',
            ]);

        $langganans = Langganan::where('pelanggan_id', $getpelanggan)
            ->where('status', '3')
            ->get();

        $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');
        $tgl_tempo = Carbon::now()->setTimezone('Asia/Jakarta')->addSeconds(86340);

        $data_ambil = [
            'email_cv' => 'info@gudangtechno.web.id',
            'nama_pelanggan' => $nama_pelanggan,
            'email_pelanggan' => $email_pelanggan,
            'no_hp_pelanggan' => $no_hp_pelanggan,
            'alamat_pelanggan' => $alamat_pelanggan,
            'id_invoice' => $id_invoice,
            'tgl_terbit' => $tgl_terbit,
            'tgl_tempo' => $tgl_tempo,
            'harga_bayar' => $harga_bayar,
            'langganans' => $langganans,
        ];

        Mail::to($email_pelanggan)->send(new Invoice($data_ambil));
        $statusinv = Invoices::find($id_invoice);
        $statusinv->status = '1';
        $statusinv->tgl_terbit = $tgl_terbit;
        $statusinv->tgl_tempo = $tgl_tempo;
        $statusinv->save();

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.invoice');
        }elseif(auth()->user()->user_role==3){
            return redirect()->route('teknisi.invoice');
        }
    }

    public function data_invoice(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $invoices = Invoices::query()->where('pelanggan_id', $user)->get();
        }else{
            $invoices = Invoices::all();
        }
        $tanggal = Carbon::now()->setTimezone('Asia/Jakarta');
        $header = 'Semua Invoice';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'tanggal', 'header'));
        }
    }

    public function invoice_belumkirim(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $invoices = Invoices::query()
                ->where('status','=','0')
                ->where('pelanggan_id', $user)
                ->get();
        }else{
            $invoices = Invoices::query()
                ->where('status','=','0')
                ->get();
        }
        $tanggal = Carbon::now()->setTimezone('Asia/Jakarta');
        $header = 'Invoice Belum Dikirim';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'tanggal', 'header'));
        }
    }

    public function invoice_melebihibatas(){
        $tanggal = Carbon::now()->setTimezone('Asia/Jakarta');
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $invoices = Invoices::query()
                ->where('status','=','1')
                ->where('tgl_tempo', '<=', $tanggal)
                ->where('pelanggan_id', $user)
                ->get();
        }else{
            $invoices = Invoices::query()
                ->where('status','=','1')
                ->where('tgl_tempo', '<=', $tanggal)
                ->get();
        }
        $header = 'Invoice Melebihi Batas Pembayaran';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'tanggal', 'header'));
        }
    }

    public function invoice_menunggu(){
        $tanggal = Carbon::now()->setTimezone('Asia/Jakarta');
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $invoices = Invoices::query()
                ->where('status','=','1')
                ->where('tgl_tempo', '>=', $tanggal)
                ->where('pelanggan_id', $user)
                ->get();
        }else{
            $invoices = Invoices::query()
                ->where('status','=','1')
                ->where('tgl_tempo', '>=', $tanggal)
                ->get();
        }
        $header = 'Invoice Menunggu Pembayaran';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.invoice', compact('invoices', 'tanggal', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'tanggal', 'header'));
        }
    }

    public function invoice_lunas(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $invoices = Invoices::query()
                ->where('status','=','2')
                ->where('pelanggan_id', $user)
                ->get();
        }else{
            $invoices = Invoices::query()
                ->where('status','=','2')
                ->get();
        }
        $header = 'Invoice Lunas';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.invoice', compact('invoices', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.invoice', compact('invoices', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'header'));
        }
    }

    public function invoice_batal(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $invoices = Invoices::query()
                ->where('status','=','3')
                ->where('pelanggan_id', $user)
                ->get();
        }else{
            $invoices = Invoices::query()
                ->where('status','=','3')
                ->get();
        }
        $header = 'Invoice Tidak Dibayar/Batal';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.invoice', compact('invoices', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.invoice', compact('invoices', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'header'));
        }
    }

    public function setujui_pembayaran($id_invoice)
    {
        $invoices = Invoices::find($id_invoice);
        $getdata = DB::table('invoices')
            ->select('*')
            ->where('id_invoice', $id_invoice)
            ->get()
            ->toArray();
        $objectToArray = (array)$getdata;
        $getdata1 = $objectToArray[0];
        $getdata2 = (array)$getdata1;
        $id_pelanggan = $getdata2['pelanggan_id'];
//        $langganans = Langganan::where('pelanggan_id', $id_pelanggan)->get();

        $invoices->status = '2';
        $invoices->harga_bayar = 0;
        $invoices->save();

        $tgl_aktif = Carbon::now()->setTimezone('Asia/Jakarta');
        $tgl_lanjut = Carbon::today()->setTimezone('Asia/Jakarta')->addDays(30);

        DB::table('langganans')
            ->where('pelanggan_id', $id_pelanggan)
            ->where('status', '3')
            ->update([
                'status'=>'4',
                'tgl_aktif' => $tgl_aktif,
                'tgl_lanjut' => $tgl_lanjut
            ]);

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.invoice');
        }elseif(auth()->user()->user_role==3){
            return redirect()->route('teknisi.invoice');
        }
//        dd($id_langganan);
    }

    public function tolak_pembayaran($id_invoice)
    {
        $invoices = Invoices::find($id_invoice);
        $getdata = DB::table('invoices')
            ->select('*')
            ->where('id_invoice', $id_invoice)
            ->get()
            ->toArray();
        $objectToArray = (array)$getdata;
        $getdata1 = $objectToArray[0];
        $getdata2 = (array)$getdata1;
        $id_pelanggan = $getdata2['pelanggan_id'];
//        $langganans = Langganan::where('pelanggan_id', $id_pelanggan)->get();

        $invoices->status = '3';
        $invoices->harga_bayar = 0;
        $invoices->save();

        DB::table('langganans')
            ->where('pelanggan_id', $id_pelanggan)
            ->where('status', '3')
            ->update([
                'status'=>'1',
            ]);

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.invoice');
        }elseif(auth()->user()->user_role==3){
            return redirect()->route('teknisi.invoice');
        }
//        dd($id_langganan);
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

        if ($status_inv=='1'){
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $harga_bayar = $harga_inv;
            $status = 'Belum Dibayar';
        }elseif ($status_inv=='2'){
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $getharga = DB::table('langganan_invoices')
                ->where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->sum('harga_satuan');
            $harga_bayar = $getharga;
            $status = 'Lunas';
        }elseif ($status_inv==null){
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $getharga = DB::table('langganan_invoices')
                ->where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->sum('harga_satuan');
            $harga_bayar = $getharga;
            $status = 'Belum Dikirim';
        }elseif ($status_inv=='0') {
            $langganans = Langinv::where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->get();
            $getharga = DB::table('langganan_invoices')
                ->where('invoice_id', $id_invoice)
                ->where('pelanggan_id', $pelanggan_id)
                ->sum('harga_satuan');
            $harga_bayar = $getharga;
            $status = 'Invoice Belum Dikirim';
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
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.print.invoice', compact('data_print'));
        }
    }
}
