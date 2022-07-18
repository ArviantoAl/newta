@extends('layouts.nowa',[
    'titlePage' => __('Daftar Kategori'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar Kategori</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Kategori</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mg-b-0 text-md-nowrap">
                            <thead style="text-align: center">
                            <tr>
                                <th>No</th>
                                <th>Nama Merk</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($jenis as $no => $jenis_bts)
                            @csrf
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $jenis_bts->nama_perangkat }}</td>
                                    <th colspan="2">Action</th>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
