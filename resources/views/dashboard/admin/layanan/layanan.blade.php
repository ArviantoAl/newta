@extends('layouts.nowa',[
    'titlePage' => __('Daftar Layanan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar Layanan</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Layanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Layanan</li>
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
                                <th>Kategori Layanan</th>
                                <th>Nama BTS</th>
                                <th>Jenis Layanan</th>
                                <th>Harga</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($layanans as $no => $layanan)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $layanan->kategori->nama_kategori }}</td>
                                    <td>{{ $layanan->bts->nama_bts }}</td>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                    <td>{{ rupiah($layanan->harga) }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('admin.editlayanan', $layanan->id_layanan) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.deletelayanan', $layanan->id_layanan) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger" type="submit" data-toggle="tooltip" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $layanans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
