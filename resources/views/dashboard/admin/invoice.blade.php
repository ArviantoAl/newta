@extends('layouts.nowa',[
    'titlePage' => __('Daftar Invoice'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar Invoice</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Invoice</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Invoice</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            @if(count($datas)>0)
            <a class="btn btn-success" href="{{ route('admin.kirimbelum') }}">
                Kirim Invoice Belum Dikirim
            </a>
            <a class="btn btn-success" href="{{ route('admin.kirimsemua') }}">
                Kirim Invoice Bulan Ini
            </a>
            @endif
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('success') }}</strong>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mg-b-0 text-md-nowrap">
                            <thead style="text-align: center">
                            <tr>
                                <th>Id Invoice</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Terbit</th>
                                <th>Tanggal Tempo</th>
                                <th>Harga Bayar</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($invoices as $no => $invoice)
                                <tr>
                                    <td>{{ $invoice->id_invoice }}</td>
                                    <td>{{ $invoice->pelanggan->name }}</td>
                                    <td>{{ $invoice->tgl_terbit }}</td>
                                    <td>{{ $invoice->tgl_tempo }}</td>
                                    <td>{{ rupiah($invoice->harga_bayar) }}</td>
                                    @if($invoice->status == null)
                                        <td>
                                            <h5><span class="badge badge-pill bg-info me-1">Belum Dikirim</span></h5>
                                        </td>
                                    @elseif($invoice->status == '0')
                                        <td>
                                            <h5><span class="badge badge-pill bg-info me-1">Tidak Aktif</span></h5>
                                        </td>
                                    @elseif($invoice->status == '1')
                                        @if($invoice->bukti_bayar == null)
                                            <td>
                                                <h5><span class="badge badge-pill bg-info me-1">Menunggu Pembayaran</span></h5>
                                            </td>
                                        @else
                                            <td>
                                                <h5><span class="badge badge-pill bg-info me-1">Sudah Dibayar</span></h5>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="{{ route('admin.approvepembayaran', $invoice->id_invoice) }}" data-toggle="tooltip" title="Setujui">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a class="btn btn-danger" href="{{ route('admin.tolakpembayaran', $invoice->id_invoice) }}" data-toggle="tooltip" title="Tolak">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            </td>
                                        @endif
                                    @elseif($invoice->status == '2')
                                        <td>
                                            <h5><span class="badge badge-pill bg-info me-1">Lunas</span></h5>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin.printinv', $invoice->id_invoice) }}" data-toggle="tooltip" title="Cetak">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
