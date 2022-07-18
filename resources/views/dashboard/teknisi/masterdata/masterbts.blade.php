@extends('layouts.nowa',[
    'titlePage' => __('Daftar BTS'),
    'sub' => ' '
])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Semua BTS</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                            <th>No</th>
                            <th>Nama BTS</th>
                            <th>Provinsi</th>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Detail Alamat</th>
                            {{-- <th>Edit</th>
                            <th>Delete</th> --}}
                            {{-- <th>Status</th> --}}
                            </thead>
                            <tbody>
                            @foreach ($bts as $no => $btss)
                                 <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $btss->nama_bts }}</td>
                                    <td>{{ $btss->provinsi->name }}</td>
                                    <td>{{ $btss->kabupaten->name }}</td>
                                    <td>{{ $btss->kecamatan->name }}</td>
                                    <td>{{ $btss->desa->name }}</td>
                                    <td>{{ $btss->detail_alamat}}</td>
                                    {{-- <td><a href="{{ url('teknisi/'.$user->id_bts.'/update-bts') }}" class="btn btn-warning">Edit</a></td>
                                    <td><a href="{{ url('teknisi/'.$user->id_bts.'/delete-bts') }}" class="btn btn-danger">Delete</a></td>
                                    <td>{{ $user->status }}</td>  --}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection

