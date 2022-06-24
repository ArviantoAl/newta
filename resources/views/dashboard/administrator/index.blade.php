@extends('layouts.app',[
    'titlePage' => __('Dashboard Administrator'),
    'sub' => ' '
])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        anda adalah administrator
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
