@extends('layouts.app',[
    'titlePage' => __('Dashboard Admin'),
    'sub' => ' '
])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        anda adalah admin
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
