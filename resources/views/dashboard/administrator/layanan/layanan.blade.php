@extends('layouts.app',[
    'titlePage' => __('Daftar Layanan'),
    'sub' => ' '
])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Layanan</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                            <th>No</th>
                            <th>Kategori Layanan</th>
                            <th>Jenis Layanan</th>
                            <th>Harga</th>
                            <th colspan="2">Action</th>
                            </thead>
                            <tbody>
                            @foreach ($layanans as $no => $layanan)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $layanan->kategori->nama_kategori }}</td>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                    <td>{{ $layanan->harga }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('administrator.editlayanan', $layanan->id_layanan) }}">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('administrator.deletelayanan', $layanan->id_layanan) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger" type="submit">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-success" href="{{ route('administrator.tambahlayanan') }}">Tambah Kategori</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
