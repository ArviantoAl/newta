<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\master\AdminController;
use App\Http\Controllers\master\PelangganController;
use App\Http\Controllers\master\LayananController;
use App\Http\Controllers\master\LanggananController;
use App\Http\Controllers\master\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemesananController;

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
})->name('home');

Route::get('pemesanan', [PemesananController::class, 'pemesanan'])->name('pesan');
Route::post('postpemesanan', [PemesananController::class, 'pelanggan_lama'])->name('pelanggan_lama');
Route::post('postpemesanann', [PemesananController::class, 'pelanggan_baru'])->name('pelanggan_baru');
Auth::routes(['verify'=>true]);

Route::get('form_register', [RegisterController::class, 'form_register'])->name('form_register');
Route::post('get_Kabupaten', [PemesananController::class, 'getKabupaten'])->name('getKabupaten');
Route::post('get_Kecamatan', [PemesananController::class, 'getKecamatan'])->name('getKecamatan');
Route::post('get_Desa', [PemesananController::class, 'getDesa'])->name('getDesa');
Route::post('get_Layanan', [PemesananController::class, 'get_layanan'])->name('getLayanan');

Route::group(['middleware'=>['userRole','auth']],function (){
    Route::get('editprofile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('updateprofile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::group(['prefix'=>'admin','middleware'=>['userRole','auth']],function (){
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//    Kelola User
    Route::get('data_user', [AdminController::class, 'data_user'])->name('admin.user');
    Route::get('tambahuser', [AdminController::class, 'tambah_user'])->name('admin.tambahuser');
    Route::post('postuser', [AdminController::class, 'post_tambah_user'])->name('admin.postuser');
    Route::get('{id_user}/edituser', [AdminController::class, 'edit_user'])->name('admin.edituser');
    Route::put('postedituser/{id_user}', [AdminController::class, 'post_edit_user'])->name('admin.postedituser');
    Route::delete('delete_user/{id_user}', [AdminController::class, 'destroy'])->name('admin.deleteuser');
//    Kelola kategori
    Route::get('data_kategori', [LayananController::class, 'index_kategori'])->name('admin.kategori');
    Route::get('tambahkategori', [LayananController::class, 'tambah_kategori'])->name('admin.tambahkategori');
    Route::post('postkategori', [LayananController::class, 'post_tambah_kategori'])->name('admin.postkategori');
    Route::delete('delete_kategori/{id_kategori}', [LayananController::class, 'destroy'])->name('admin.deletekategori');
    //    Kelola layanan
    Route::get('data_layanan', [LayananController::class, 'index_layanan'])->name('admin.layanan');
    Route::get('tambahlayanan', [LayananController::class, 'tambah_layanan'])->name('admin.tambahlayanan');
    Route::post('postlayanan', [LayananController::class, 'post_tambah_layanan'])->name('admin.postlayanan');
    Route::get('{id_layanan}/editlayanan', [LayananController::class, 'edit_layanan'])->name('admin.editlayanan');
    Route::put('posteditlayanan/{id_layanan}', [LayananController::class, 'post_edit_layanan'])->name('admin.posteditlayanan');
    Route::delete('delete_layanan/{id_layanan}', [LayananController::class, 'destroy_layanan'])->name('admin.deletelayanan');
    // kelola langganan
    Route::get('data_langganan', [LanggananController::class, 'semua_langganan'])->name('admin.langganan');
    Route::get('langganan_baru', [LanggananController::class, 'langganan_baru'])->name('admin.langgananbaru');
    Route::get('langganan_setuju', [LanggananController::class, 'langganan_setuju'])->name('admin.langganansetuju');
    Route::get('langganan_menunggu', [LanggananController::class, 'langganan_menunggu'])->name('admin.langgananmenunggu');
    Route::get('langganan_batal', [LanggananController::class, 'langganan_batal'])->name('admin.langgananbatal');
    Route::get('langganan_aktif', [LanggananController::class, 'langganan_aktif'])->name('admin.langgananaktif');
    Route::get('langganan_kadaluarsa', [LanggananController::class, 'langganan_kadaluarsa'])->name('admin.langganankadaluarsa');
    Route::get('setujui/{id_langganan}', [LanggananController::class, 'setujui_langganan'])->name('admin.approvelangganan');
    Route::get('tolak/{id_langganan}', [LanggananController::class, 'tolak_langganan'])->name('admin.rejectlangganan');
    //kelola invoice
    Route::get('data_invoice', [InvoiceController::class, 'data_invoice'])->name('admin.invoice');
    Route::get('invoice_belum_kirim', [InvoiceController::class, 'invoice_belumkirim'])->name('admin.inv_belumkirim');
    Route::get('invoice_melebihi_batas', [InvoiceController::class, 'invoice_melebihibatas'])->name('admin.inv_melebihibatas');
    Route::get('invoice_menunggu_bayar', [InvoiceController::class, 'invoice_menunggu'])->name('admin.inv_menunggu');
    Route::get('invoice_lunas', [InvoiceController::class, 'invoice_lunas'])->name('admin.inv_lunas');
    Route::get('invoice_batal', [InvoiceController::class, 'invoice_batal'])->name('admin.inv_batal');
    Route::get('kirim_invoice/{id_invoice}', [InvoiceController::class, 'kirim_invoice'])->name('admin.kiriminvoice');
    Route::get('setujui_pembayaran/{id_invoice}', [InvoiceController::class, 'setujui_pembayaran'])->name('admin.approvepembayaran');
    Route::get('tolak_pembayaran/{id_invoice}', [InvoiceController::class, 'tolak_pembayaran'])->name('admin.tolakpembayaran');
    Route::get('print/{id_invoice}', [InvoiceController::class, 'print_invoice'])->name('admin.printinv');
});

Route::group(['prefix'=>'administrator','middleware'=>['userRole','auth']],function (){
    Route::get('dashboard', [AdminController::class, 'index_administrator'])->name('administrator.dashboard');
    Route::get('data_user', [AdminController::class, 'data_user_notadmin'])->name('administrator.user');
    //    Kelola layanan
    Route::get('data_layanan', [LayananController::class, 'index_layanan'])->name('administrator.layanan');
    Route::get('tambahlayanan', [LayananController::class, 'tambah_layanan'])->name('administrator.tambahlayanan');
    Route::post('postlayanan', [LayananController::class, 'post_tambah_layanan'])->name('administrator.postlayanan');
    Route::get('{id_layanan}/editlayanan', [LayananController::class, 'edit_layanan'])->name('administrator.editlayanan');
    Route::put('posteditlayanan/{id_layanan}', [LayananController::class, 'post_edit_layanan'])->name('administrator.posteditlayanan');
    Route::delete('delete_layanan/{id_layanan}', [LayananController::class, 'destroy_layanan'])->name('administrator.deletelayanan');
    // kelola langganan
    Route::get('data_langganan', [LanggananController::class, 'semua_langganan'])->name('administrator.langganan');
    Route::get('langganan_baru', [LanggananController::class, 'langganan_baru'])->name('administrator.langgananbaru');
    Route::get('langganan_setuju', [LanggananController::class, 'langganan_setuju'])->name('administrator.langganansetuju');
    Route::get('langganan_menunggu', [LanggananController::class, 'langganan_menunggu'])->name('administrator.langgananmenunggu');
    Route::get('langganan_batal', [LanggananController::class, 'langganan_batal'])->name('administrator.langgananbatal');
    Route::get('langganan_aktif', [LanggananController::class, 'langganan_aktif'])->name('administrator.langgananaktif');
    Route::get('langganan_kadaluarsa', [LanggananController::class, 'langganan_kadaluarsa'])->name('administrator.langganankadaluarsa');
    Route::get('setujui/{id_langganan}', [LanggananController::class, 'setujui_langganan'])->name('administrator.approvelangganan');
    Route::get('tolak/{id_langganan}', [LanggananController::class, 'tolak_langganan'])->name('administrator.rejectlangganan');
    // kelola invoice
    Route::get('data_invoice', [InvoiceController::class, 'data_invoice'])->name('administrator.invoice');
    Route::get('invoice_belum_kirim', [InvoiceController::class, 'invoice_belumkirim'])->name('administrator.inv_belumkirim');
    Route::get('invoice_melebihi_batas', [InvoiceController::class, 'invoice_melebihibatas'])->name('administrator.inv_melebihibatas');
    Route::get('invoice_menunggu_bayar', [InvoiceController::class, 'invoice_menunggu'])->name('administrator.inv_menunggu');
    Route::get('invoice_lunas', [InvoiceController::class, 'invoice_lunas'])->name('administrator.inv_lunas');
    Route::get('invoice_batal', [InvoiceController::class, 'invoice_batal'])->name('administrator.inv_batal');
});

Route::group(['prefix'=>'keuangan','middleware'=>['userRole','auth']],function (){
    Route::get('dashboard', [AdminController::class, 'index_keuangan'])->name('keuangan.dashboard');
    Route::get('data_user', [AdminController::class, 'data_user_notadmin'])->name('keuangan.user');
    Route::get('data_layanan', [LayananController::class, 'index_layanan'])->name('keuangan.layanan');
    // kelola langganan
    Route::get('data_langganan', [LanggananController::class, 'semua_langganan'])->name('keuangan.langganan');
    Route::get('langganan_baru', [LanggananController::class, 'langganan_baru'])->name('keuangan.langgananbaru');
    Route::get('langganan_setuju', [LanggananController::class, 'langganan_setuju'])->name('keuangan.langganansetuju');
    Route::get('langganan_menunggu', [LanggananController::class, 'langganan_menunggu'])->name('keuangan.langgananmenunggu');
    Route::get('langganan_batal', [LanggananController::class, 'langganan_batal'])->name('keuangan.langgananbatal');
    Route::get('langganan_aktif', [LanggananController::class, 'langganan_aktif'])->name('keuangan.langgananaktif');
    Route::get('langganan_kadaluarsa', [LanggananController::class, 'langganan_kadaluarsa'])->name('keuangan.langganankadaluarsa');
//    kelola invoice
    Route::get('data_invoice', [InvoiceController::class, 'data_invoice'])->name('keuangan.invoice');
    Route::get('invoice_belum_kirim', [InvoiceController::class, 'invoice_belumkirim'])->name('keuangan.inv_belumkirim');
    Route::get('invoice_melebihi_batas', [InvoiceController::class, 'invoice_melebihibatas'])->name('keuangan.inv_melebihibatas');
    Route::get('invoice_menunggu_bayar', [InvoiceController::class, 'invoice_menunggu'])->name('keuangan.inv_menunggu');
    Route::get('invoice_lunas', [InvoiceController::class, 'invoice_lunas'])->name('keuangan.inv_lunas');
    Route::get('invoice_batal', [InvoiceController::class, 'invoice_batal'])->name('keuangan.inv_batal');
    Route::get('kirim_invoice/{id_invoice}', [LanggananController::class, 'kirim_invoice'])->name('keuangan.kiriminvoice');
    Route::get('setujui_pembayaran/{id_invoice}', [InvoiceController::class, 'setujui_pembayaran'])->name('keuangan.approvepembayaran');
    Route::get('tolak_pembayaran/{id_invoice}', [InvoiceController::class, 'tolak_pembayaran'])->name('keuangan.tolakpembayaran');
    Route::get('print/{id_invoice}', [InvoiceController::class, 'print_invoice'])->name('keuangan.printinv');
});

Route::group(['prefix'=>'pelanggan','middleware'=>['userRole','auth', 'verified']],function (){
    Route::get('dashboard', [PelangganController::class, 'index'])->name('pelanggan.dashboard');
    Route::get('data_layanan', [LayananController::class, 'index_layanan'])->name('pelanggan.layanan');
    Route::get('pemesanan', [PelangganController::class, 'pemesanan'])->name('pelanggan.pemesanan');
    Route::post('post_pemesanan', [PelangganController::class, 'post_pesan'])->name('postpemesanan');
    //langganan
    Route::get('data_langganan', [LanggananController::class, 'semua_langganan'])->name('pelanggan.langganan');
    Route::get('langganan_baru', [LanggananController::class, 'langganan_baru'])->name('pelanggan.langgananbaru');
    Route::get('langganan_setuju', [LanggananController::class, 'langganan_setuju'])->name('pelanggan.langganansetuju');
    Route::get('langganan_menunggu', [LanggananController::class, 'langganan_menunggu'])->name('pelanggan.langgananmenunggu');
    Route::get('langganan_batal', [LanggananController::class, 'langganan_batal'])->name('pelanggan.langgananbatal');
    Route::get('langganan_aktif', [LanggananController::class, 'langganan_aktif'])->name('pelanggan.langgananaktif');
    Route::get('langganan_kadaluarsa', [LanggananController::class, 'langganan_kadaluarsa'])->name('pelanggan.langganankadaluarsa');
    //invoice
    Route::get('data_invoice', [InvoiceController::class, 'data_invoice'])->name('pelanggan.invoice');
    Route::get('invoice_belum_kirim', [InvoiceController::class, 'invoice_belumkirim'])->name('pelanggan.inv_belumkirim');
    Route::get('invoice_melebihi_batas', [InvoiceController::class, 'invoice_melebihibatas'])->name('pelanggan.inv_melebihibatas');
    Route::get('invoice_menunggu_bayar', [InvoiceController::class, 'invoice_menunggu'])->name('pelanggan.inv_menunggu');
    Route::get('invoice_lunas', [InvoiceController::class, 'invoice_lunas'])->name('pelanggan.inv_lunas');
    Route::get('invoice_batal', [InvoiceController::class, 'invoice_batal'])->name('pelanggan.inv_batal');
});
