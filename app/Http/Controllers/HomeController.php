<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->user_role==1){
            return view('dashboard.admin.index');
        }elseif(auth()->user()->user_role==2){
            return view('teknisi.dashboard');
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.index');
        }
//        return view('home');
    }
}
