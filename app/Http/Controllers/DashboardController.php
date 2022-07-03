<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index(){

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.index');
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.teknisi.index');
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.index');
        }
    }
}
