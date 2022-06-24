<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => ['required', 'email'],
        ]);

        auth()->user()->update($request->all());
        return redirect()->back()
            ->with('message', 'Berhasil diubah');
    }
}
