<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Mail\MailAdmins;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index(){
        return view('dashboard.admin.index');
    }

    public function index_administrator(){
        return view('dashboard.administrator.index');
    }

    public function index_keuangan(){
        return view('dashboard.keuangan.index');
    }

    public function data_user(){
        $roles = Role::all();
        $users = User::orderBy('name', 'ASC')
            ->get();
        return view('dashboard.admin.user.user', compact('roles', 'users'));
    }

    public function data_user_notadmin(){
        $roles = Role::all();
        $users = User::where('user_role', 4)->orderBy('name', 'ASC')
            ->get();

        if (auth()->user()->user_role==2){
            return view('dashboard.administrator.user', compact('roles', 'users'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.keuangan.user', compact('roles', 'users'));
        }
    }

    public function tambah_user(){
        $roles = Role::all();
        $provincies = Province::all();
        $user = new User();
        return view('dashboard.admin.user.tambah_user', compact('roles', 'user', 'provincies'));
    }

    public function post_tambah_user(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);

        $pass = rand(100000, 999999);
        $password = Hash::make($pass);
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;;

        $user = new User();
        $user->name = $name;
        $user->username = $username;
        $user->email = $email;
        $user->password = $password;
        $user->user_role = $request->user_role;
        $user->no_hp = $request->no_hp;

//        $getprovinsi = DB::table('provinces')
//            ->select('*')
//            ->where('id', $request->id_provinsi)
//            ->get()
//            ->toArray();
//        $objectToArray = (array)$getprovinsi;
//        $prov1 = $objectToArray[0];
//        $prov2 = (array)$prov1;
//        $provinsi = $prov2['name'];
//
//        $getkabupaten = DB::table('regencies')
//            ->select('*')
//            ->where('id', $request->id_kabupaten)
//            ->get()
//            ->toArray();
//        $objectToArray = (array)$getkabupaten;
//        $kab1 = $objectToArray[0];
//        $kab2 = (array)$kab1;
//        $kabupaten = $kab2['name'];
//
//        $getkecamatan = DB::table('districts')
//            ->select('*')
//            ->where('id', $request->id_kecamatan)
//            ->get()
//            ->toArray();
//        $objectToArray = (array)$getkecamatan;
//        $kec1 = $objectToArray[0];
//        $kec2 = (array)$kec1;
//        $kecamatan = $kec2['name'];
//
//        $getdesa = DB::table('villages')
//            ->select('*')
//            ->where('id', $request->id_desa)
//            ->get()
//            ->toArray();
//        $objectToArray = (array)$getdesa;
//        $desa1 = $objectToArray[0];
//        $desa2 = (array)$desa1;
//        $desa = $desa2['name'];
//
//        $alamat = $request->id_alamat;
//        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
//        $user->alamat = implode(", ",$lengkap);

        if ($request->user_role == 1){
            $nama_role = 'Admin';
        }elseif ($request->user_role == 2){
            $nama_role = 'Administrator';
        }elseif ($request->user_role == 3){
            $nama_role = 'Keuangan';
        }

        $user->save();

        $data_ambil = [
            'nama' => $name,
            'nama_role' => $nama_role,
            'username' => $username,
            'email' => $email,
            'password' => $pass,
        ];

        Mail::to($email)->send(new MailAdmins($data_ambil));

        return redirect()->route('admin.user')
            ->with('success','User berhasil ditambahkan.');
    }

    public function edit_user($id_user){
        $roles = Role::all();
        $user = User::find($id_user);
        $roleuser = $user->user_role;

        $get_role = DB::table('roles')
            ->select('*')
            ->where('id_role', $roleuser)
            ->get()
            ->toArray();
        $objectToArray = (array)$get_role;
        $role1 = $objectToArray[0];
        $role2 = (array)$role1;
        $nama_role = $role2['nama_role'];
        $id_role = $role2['id_role'];

        return view('dashboard.admin.user.edit_user', compact('roles', 'user', 'nama_role', 'id_role'));
    }

    public function post_edit_user(Request $request ,$id_user){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);

        $user = User::find($id_user);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->user_role = $request->user_role;

        $user->save();

        return redirect()->route('admin.user')
            ->with('success','User berhasil diubah.');
    }

    public function destroy($id_user)
    {
        $user = User::find($id_user);
        $user->delete();

        return redirect()->route('admin.user')
            ->with('success','User berhasil dihapus.');
    }
}
