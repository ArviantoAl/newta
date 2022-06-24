@extends('layouts.app',[
    'titlePage' => __('Daftar Langganan'),
    'sub' => $header
])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $header }}</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        @if(count($langganans)==0)
                            <p>Tidak ada data</p>
                        @elseif(count($langganans)>0)
                            <table class="table table-bordered table-md">
                                <thead>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat Pemasangan</th>
                                <th>Jenis Langganan</th>
                                <th>Tanggal Expired</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                </thead>
                                <tbody>
                                @foreach ($langganans as $no => $langganan)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $langganan->pelanggan->name }}</td>
                                        <td>{{ $langganan->alamat_pasang }}</td>
                                        <td>{{ $langganan->layanan->nama_layanan }}</td>
                                        <td>{{ $langganan->tgl_lanjut }}</td>
                                        @if($langganan->status == 0)
                                            <td><div class="badge badge-info">Langganan Baru</div></td>
                                            <td>
                                                <a class="btn btn-success" href="{{ route('administrator.approvelangganan', $langganan->id_langganan) }}">Setuju</a>

                                                <a class="btn btn-danger" href="{{ route('administrator.rejectlangganan', $langganan->id_langganan) }}">Tolak</a>
                                            </td>
                                        @elseif($langganan->status == 1)
                                            <td><div class="badge badge-danger">Langganan Dibatalkan</div></td>
                                        @elseif($langganan->status == 2)
                                            <td><div class="badge badge-warning">Langganan Disetujui</div></td>
                                        @elseif($langganan->status == 3)
                                            <td><div class="badge badge-warning">Menunggu pembayaran</div></td>
                                        @elseif($langganan->status == 4)
                                            @if($today >= $langganan->tgl_lanjut)
                                                <td><div class="badge badge-danger">Langganan Kadaluarsa</div></td>
                                                <td>
                                                    <a class="btn btn-warning" href="{{ route('administrator.approvelangganan', $langganan->id_langganan) }}">Ajukan Pengaktifan</a>
                                                </td>
                                            @else
                                                <td><div class="badge badge-success">Langganan Aktif</div></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
