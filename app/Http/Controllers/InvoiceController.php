<?php

namespace App\Http\Controllers;

use App\Mail\Invoice;
use App\Models\Invoice as Invoices;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\User;
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
        $datas = Invoices::query()
            ->where('status', '=', null)
            ->get();
        $tanggal = Carbon::now()->setTimezone('Asia/Jakarta');

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.invoice', compact('invoices', 'tanggal', 'datas'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.teknisi.invoice', compact('invoices', 'tanggal', 'datas'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.invoice', compact('invoices', 'tanggal', 'datas'));
        }
    }

    public function kirim_belum(){
        $datas = Invoices::query()
            ->where('status', '=', null)
            ->get();

//        $datainv = [];
        foreach($datas as $data){
            $pelanggan_id = $data->pelanggan_id;
            $harga_bayar = $data->harga_bayar;
            $id_invoice = $data->id_invoice;

            $user = User::find($pelanggan_id);
            $nama_pelanggan = $user->name;
            $email_pelanggan = $user->email;
            $no_hp_pelanggan = $user->no_hp;
            $alamat_pelanggan = $user->alamat;

            $langganans = Langganan::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('status', '=', '1')
                ->get();
//            $datainv[]=$langganans;

            $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');
            $tgl_tempo = Carbon::now()->setTimezone('Asia/Jakarta')->addMonth();

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
        }
        return back()->with('success', 'Invoice telah terkirim semua!');

    }

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
        }elseif(auth()->user()->user_role==2){
            return redirect()->route('teknisi.invoice');
        }
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
        $invoice->save();

        $bukti->move(public_path('bukti_bayar'), $name);
        return redirect()->back();
    }
}
