<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\Layanan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LanggananController extends Controller
{
    public function semua_langganan(){
        if(auth()->user()->user_role==3){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()->where('pelanggan_id', $user)->paginate(10);
        }else{
            $langganans = Langganan::query()->paginate(10);
        }
        $today = Carbon::today()->setTimezone('Asia/Jakarta');
        $header = 'Semua Langganan';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.teknisi.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'today', 'header'));
        }
    }

    public function langganan_baru(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()
                ->where('status', '0')
                ->where('pelanggan_id', $user)
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $langganans = Langganan::query()
                ->where('status', '0')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $header = 'Langganan Baru';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'header'));
        }
    }

    public function langganan_setuju(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()
                ->where('status', '2')
                ->where('pelanggan_id', $user)
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $langganans = Langganan::query()
                ->where('status', '2')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $header = 'Langganan Disetujui';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'header'));
        }
    }

    public function langganan_menunggu(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()
                ->where('status', '3')
                ->where('pelanggan_id', $user)
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $langganans = Langganan::query()
                ->where('status', '3')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $header = 'Langganan Menunggu Pembayaran';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'header'));
        }
    }

    public function langganan_batal(){
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()
                ->where('status', '1')
                ->where('pelanggan_id', $user)
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $langganans = Langganan::query()
                ->where('status', '1')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $header = 'Langganan Batal';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.langganan', compact('langganans', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'header'));
        }
    }

    public function langganan_aktif(){
        $today = Carbon::today()->setTimezone('Asia/Jakarta');
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()
                ->where('status', '4')
                ->where('tgl_lanjut', '>', $today)
                ->where('pelanggan_id', $user)
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $langganans = Langganan::query()
                ->where('status', '4')
                ->where('tgl_lanjut', '>', $today)
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $header = 'Langganan Aktif';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'today', 'header'));
        }
    }

    public function langganan_kadaluarsa(){
        $today = Carbon::today()->setTimezone('Asia/Jakarta');
        if(auth()->user()->user_role==4){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()
                ->where('status', '4')
                ->where('tgl_lanjut', '<', $today)
                ->where('pelanggan_id', $user)
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $langganans = Langganan::query()
                ->where('status', '4')
                ->where('tgl_lanjut', '<', $today)
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $header = 'Langganan Kadaluarsa';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.administrator.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.teknisi.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==4){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'today', 'header'));
        }
    }

    public function setujui_langganan($id_langganan){
        $langganan = Langganan::find($id_langganan);

        $getlangganan = Langganan::where('id_langganan', $id_langganan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlangganan;
        $lang1 = $objectToArray[0];
        $lang2 = (array)$lang1;
        $id_user = $lang2['pelanggan_id'];
        $id_layanan = $lang2['layanan_id'];

        $getlayanan = Layanan::where('id_layanan', $id_layanan)
            ->get()
            ->toArray();
        $objectToArray = (array)$getlayanan;
        $layanan1 = $objectToArray[0];
        $layanan2 = (array)$layanan1;
        $harga_satuan = $layanan2['harga'];

        if($langganan)
        {
            $langganan->status = '2';
            $langganan->harga_satuan = $harga_satuan;
            $langganan->tgl_lanjut = null;
            $langganan->save();

            $getharga = DB::table('langganans')
                ->where('pelanggan_id', $id_user)
                ->where('status', '2')
                ->sum('harga_satuan');
        }

        $getinvoice = Invoice::where('pelanggan_id', $id_user)
            ->where('status', '0')
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
        }
        else{
            $huruf = 'INV';
            $acak1 = rand(10, 99);
            $acak2 = rand(10, 99);
            $lengkap = array($huruf,$acak1,$id_user,$acak2);
            $id_invoice = implode($lengkap);

            $invoice = new Invoice();
            $invoice->id_invoice = $id_invoice;
            $invoice->pelanggan_id = $id_user;
            $invoice->harga_bayar = $getharga;
            $invoice->status = '0';
            $invoice->save();

            $langinv = new Langinv();
            $langinv->invoice_id = $id_invoice;
        }

        $langinv->pelanggan_id = $id_user;
        $langinv->layanan_id = $id_layanan;
        $langinv->harga_satuan = $harga_satuan;
        $langinv->langganan_id = $id_langganan;
        $langinv->save();

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.langganan')
                ->with('success','Status Langganan berhasil diubah.');
        }elseif(auth()->user()->user_role==2){
            return redirect()->route('administrator.langganan')
                ->with('success','Status Langganan berhasil diubah.');
        }
    }

    public function tolak_langganan($id_langganan){
        $langganan = Langganan::find($id_langganan);

        if($langganan)
        {
            $langganan->status = '1';
            $langganan->save();
        }

        if (auth()->user()->user_role==1){
            return redirect()->route('admin.langganan')
                ->with('success','Status Langganan berhasil diubah.');
        }elseif(auth()->user()->user_role==2){
            return redirect()->route('administrator.langganan')
                ->with('success','Status Langganan berhasil diubah.');
        }
    }
}
