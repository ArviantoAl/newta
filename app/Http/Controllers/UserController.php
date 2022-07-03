<?php

namespace App\Http\Controllers;

use App\Mail\MailAdmins;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function data_user(){
        $roles = Role::all();
        $users = User::query()->paginate(10);
        return view('dashboard.admin.user.user', compact('roles', 'users'));
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
        $user->status = '1';

        if ($request->user_role == 1){
            $nama_role = 'Admin';
        }elseif ($request->user_role == 2){
            $nama_role = 'Teknisi';
        }elseif ($request->user_role == 3){
            $nama_role = 'Pelanggan';
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
