<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BtsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\master\LanggananController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify'=>true]);

Route::get('form_register', [RegisterController::class, 'form_register'])->name('form_register');
Route::post('get_Kabupaten', [PemesananController::class, 'getKabupaten'])->name('getKabupaten');
Route::post('get_Kecamatan', [PemesananController::class, 'getKecamatan'])->name('getKecamatan');
Route::post('get_Desa', [PemesananController::class, 'getDesa'])->name('getDesa');
Route::post('get_turunan', [PemesananController::class, 'get_turunan'])->name('getTurunan');

Route::group(['middleware'=>['userRole','auth']],function (){
    Route::get('edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('update-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('change-password', [ProfileController::class, 'edit_pass'])->name('change.password');
    Route::post('update-password', [ProfileController::class, 'changePassword'])->name('password.update');
});

Route::group(['prefix'=>'admin','middleware'=>['userRole','auth']],function (){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
//    Kelola User
    Route::get('data_user', [UserController::class, 'data_user'])->name('admin.user');
    Route::get('data_pelanggan_aktif', [UserController::class, 'pelanggan_aktif'])->name('admin.pelangganaktif');
    Route::get('tambahuser', [UserController::class, 'tambah_user'])->name('admin.tambahuser');
    Route::post('postuser', [UserController::class, 'post_tambah_user'])->name('admin.postuser');
    Route::get('{id_user}/edituser', [UserController::class, 'edit_user'])->name('admin.edituser');
    Route::put('postedituser/{id_user}', [UserController::class, 'post_edit_user'])->name('admin.postedituser');
    Route::delete('delete_user/{id_user}', [UserController::class, 'destroy'])->name('admin.deleteuser');
    //    Kelola layanan
    Route::get('data_layanan', [LayananController::class, 'index_layanan'])->name('admin.layanan');
    Route::get('tambahlayanan', [LayananController::class, 'tambah_layanan'])->name('admin.tambahlayanan');
    Route::post('postlayanan', [LayananController::class, 'post_tambah_layanan'])->name('admin.postlayanan');
    Route::get('{id_layanan}/editlayanan', [LayananController::class, 'edit_layanan'])->name('admin.editlayanan');
    Route::put('posteditlayanan/{id_layanan}', [LayananController::class, 'post_edit_layanan'])->name('admin.posteditlayanan');
    Route::get('nonaktif_layanan/{id_layanan}', [LayananController::class, 'nonaktif_layanan'])->name('admin.nonaktiflayanan');
    Route::get('aktif_layanan/{id_layanan}', [LayananController::class, 'aktif_layanan'])->name('admin.aktiflayanan');
    // kelola langganan
    Route::get('data_langganan', [LanggananController::class, 'semua_langganan'])->name('admin.langganan');
    Route::get('setujui/{id_langganan}', [PemesananController::class, 'setujui_pesan'])->name('admin.approvelangganan');
    Route::put('postsetujui/{id_langganan}', [PemesananController::class, 'post_setujui_pesan'])->name('admin.postapprove');
    Route::get('tolak/{id_langganan}', [PemesananController::class, 'tolak_langganan'])->name('admin.rejectlangganan');

    //pemesanan
    Route::get('pemesanan', [PemesananController::class, 'pemesanan'])->name('admin.form_pemesanan');
    Route::post('postpemesanan', [PemesananController::class, 'pelanggan_lama'])->name('pelanggan_lama');
    Route::post('postpemesanan2', [PemesananController::class, 'pelanggan_baru'])->name('pelanggan_baru');
    Route::post('postpemesanan3', [PemesananController::class, 'pelanggan_onprogress'])->name('pelanggan_onprogress');
    //kelola invoice
    Route::get('data_invoice', [InvoiceController::class, 'data_invoice'])->name('admin.invoice');
    Route::get('kirim_semua', [InvoiceController::class, 'kirim_semua'])->name('admin.kirimsemua');
    Route::get('setujui_pembayaran/{id_invoice}', [InvoiceController::class, 'setujui_pembayaran'])->name('admin.approvepembayaran');
    Route::get('tolak_pembayaran/{id_invoice}', [InvoiceController::class, 'tolak_pembayaran'])->name('admin.tolakpembayaran');
    Route::get('print/{id_invoice}', [InvoiceController::class, 'print_invoice'])->name('admin.printinv');
    Route::post('detail_invoice', [InvoiceController::class, 'get_detail'])->name('getDetail');
});

Route::group(['prefix'=>'teknisi','middleware'=>['userRole','auth']],function (){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('teknisi.dashboard');

    Route::get('master_bts', [BtsController::class, 'index_bts'])->name('teknisi.masterbts');
    Route::get('getbts', [BtsController::class, 'tambah_bts'])->name('teknisi.tambahmasterbts');
    Route::post('postbts', [BtsController::class, 'post_tambah_bts'])->name('teknisi.posttambahmasterbts');

    Route::get('master_kategori', [BtsController::class, 'index_kategori'])->name('teknisi.masterkategori');
    Route::get('getkategori', [BtsController::class, 'get_tambah_kategori'])->name('teknisi.tambahmasterkategori');
    Route::post('postkategori', [BtsController::class, 'post_tambah_kategori'])->name('teknisi.posttambahmasterkategori');
    Route::get('{id_jenis}/editkategori', [DashboardController::class, 'edit_kategori'])->name('teknisi.editkategori');
    Route::put('posteditkategori/{id_jenis}', [DashboardController::class, 'post_edit_kategori'])->name('admin.posteditkategori');

    Route::get('master_frekuensi', [BtsController::class, 'index_frekuensi'])->name('teknisi.masterfrekuensi');

    Route::get('perangkat', [dashboardController::class, 'index'])->name('teknisi.perangkat');
    Route::get('getperangkat', [dashboardController::class, 'index'])->name('teknisi.tambahperangkat');
    Route::post('postperangkat', [dashboardController::class, 'index'])->name('teknisi.posttambahperangkat');

    Route::get('pelanggan', [BtsController::class, 'index_pelanggan'])->name('teknisi.pelanggan');
    Route::get('getpelanggan', [BtsController::class, 'get_tambah_pelanggan'])->name('teknisi.tambahpelanggan');
    Route::post('postpelanggan', [BtsController::class, 'post_tambah_pelanggan'])->name('teknisi.posttambahpelanggan');
    
//    kelola langganan
    Route::get('data_layanan', [LayananController::class, 'index_layanan'])->name('teknisi.layanan');
    Route::get('data_langganan', [LanggananController::class, 'semua_langganan'])->name('teknisi.langganan');
    Route::get('langganan_baru', [LanggananController::class, 'langganan_baru'])->name('teknisi.langgananbaru');
    Route::get('langganan_setuju', [LanggananController::class, 'langganan_setuju'])->name('teknisi.langganansetuju');
    Route::get('langganan_menunggu', [LanggananController::class, 'langganan_menunggu'])->name('teknisi.langgananmenunggu');
    Route::get('langganan_batal', [LanggananController::class, 'langganan_batal'])->name('teknisi.langgananbatal');
    Route::get('langganan_aktif', [LanggananController::class, 'langganan_aktif'])->name('teknisi.langgananaktif');
    Route::get('langganan_kadaluarsa', [LanggananController::class, 'langganan_kadaluarsa'])->name('teknisi.langganankadaluarsa');

//    kelola invoice
    Route::get('data_invoice', [InvoiceController::class, 'data_invoice'])->name('teknisi.invoice');
    Route::get('invoice_belum_kirim', [InvoiceController::class, 'invoice_belumkirim'])->name('teknisi.inv_belumkirim');
    Route::get('invoice_melebihi_batas', [InvoiceController::class, 'invoice_melebihibatas'])->name('teknisi.inv_melebihibatas');
    Route::get('invoice_menunggu_bayar', [InvoiceController::class, 'invoice_menunggu'])->name('teknisi.inv_menunggu');
    Route::get('invoice_lunas', [InvoiceController::class, 'invoice_lunas'])->name('teknisi.inv_lunas');
    Route::get('invoice_batal', [InvoiceController::class, 'invoice_batal'])->name('teknisi.inv_batal');
    Route::get('kirim_invoice/{id_invoice}', [LanggananController::class, 'kirim_invoice'])->name('teknisi.kiriminvoice');
    Route::get('setujui_pembayaran/{id_invoice}', [InvoiceController::class, 'setujui_pembayaran'])->name('teknisi.approvepembayaran');
    Route::get('tolak_pembayaran/{id_invoice}', [InvoiceController::class, 'tolak_pembayaran'])->name('teknisi.tolakpembayaran');
    Route::get('print/{id_invoice}', [InvoiceController::class, 'print_invoice'])->name('teknisi.printinv');
});

Route::group(['prefix'=>'pelanggan','middleware'=>['userRole','auth', 'verified']],function (){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('pelanggan.dashboard');
    //langganan
    Route::get('data_langganan', [LanggananController::class, 'semua_langganan'])->name('pelanggan.langganan');
    //invoice
    Route::get('data_invoice', [InvoiceController::class, 'data_invoice'])->name('pelanggan.invoice');
    Route::post('bukti/{id_inv}', [InvoiceController::class, 'bukti'])->name('pelanggan.bukti');
    Route::get('print/{id_invoice}', [InvoiceController::class, 'print_invoice'])->name('pelanggan.printinv');
});

// Route::group(['prefix'=>'tkenisi','middleware'=>['userRole','auth']],function (){
//     Route::get('dashboard', [DashboardController::class, 'index'])->name('teknisi.dashboard');
//     //masterdata
// });