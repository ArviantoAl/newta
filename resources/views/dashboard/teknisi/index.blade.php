@extends('layouts.nowa',[
    'titlePage' => __('Dashboard Teknisi'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Dasboard</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard Teknisi</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6>anda adalah Teknisi</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection