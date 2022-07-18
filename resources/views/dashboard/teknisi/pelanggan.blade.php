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
                            <th>Nama Pelanggan</th>
                            <th>Connect ke BTS</th>
                            <th>Connect ke Pelanggan</th>
                            <th>Provinsi</th>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Detail Alamat</th>
                            <th>Alamat Pasang</th>
                            <th>Frekuensi</th>
                            <th>SSID</th>
                            <th>IP</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            {{-- <th>Edit</th>
                            <th>Delete</th> --}}
                            {{-- <th>Status</th> --}}
                            </thead>
                            <tbody>
                            @foreach ($turunan_bts as $no => $turbts)
                                 <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $turbts->nama_bts }}</td>
                                    <td>{{ $turbts->bts_id }}</td>
                                    <td>{{ $turbts->nama_turunan }}</td>
                                    <td>{{ $turbts->provinsi->name }}</td>
                                    <td>{{ $turbts->kabupaten->name }}</td>
                                    <td>{{ $turbts->kecamatan->name }}</td>
                                    <td>{{ $turbts->desa->name }}</td>
                                    <td>{{ $turbts->detail_alamat}}</td>
                                    <td>{{ $turbts->alamat_pasang}}</td>
                                    <td>{{ $turbts->frekuensi}}</td>
                                    <td>{{ $turbts->ssid}}</td>
                                    <td>{{ $turbts->ip}}</td>
                                    <td>{{ $turbts->lokasi}}</td>
                                    <td>{{ $turbts->status_id}}</td>
                                    {{-- <td><a href="{{ url('teknisi/'.$use
                                        r->id_bts.'/update-bts') }}" class="btn btn-warning">Edit</a></td>
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

