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
                                <th>Status</th>
                                </thead>
                                <tbody>
                                @foreach ($langganans as $no => $langganan)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $langganan->pelanggan->name }}</td>
                                        <td>{{ $langganan->alamat_pasang }}</td>
                                        <td>{{ $langganan->layanan->nama_layanan }}</td>
                                        @if($langganan->status == 0)
                                            <td>Langganan Baru</td>
                                        @elseif($langganan->status == 1)
                                            <td>Langganan Tidak disetujui</td>
                                        @elseif($langganan->status == 2)
                                            <td>Langganan Disetujui</td>
                                        @elseif($langganan->status == 3)
                                            <td>Langganan menunggu pembayaran, Cek Email untuk Melihat Invoice/Tagihan Anda</td>
                                        @elseif($langganan->status == 4)
                                            <td>Langganan Aktif</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        <a class="btn btn-success" href="{{ route('pelanggan.pemesanan') }}">Tambah Langganan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
