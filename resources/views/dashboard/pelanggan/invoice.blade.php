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
                                            <td>
                                                <a class="btn btn-warning" data-bs-toggle="collapse" data-bs-target="#demo{{$invoice->id_invoice}}" data-toggle="tooltip" title="Upload Bukti Pembayaran">
                                                    <i class="fa fa-upload"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                <h5><span class="badge badge-pill bg-info me-1">Sudah Dibayar</span></h5>
                                            </td>
                                            <td>
                                                <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal{{$invoice->id_invoice}}" data-toggle="tooltip" title="Lihat Bukti Bayar">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        @endif
                                    @elseif($invoice->status == '2')
                                        <td>
                                            <h5><span class="badge badge-pill bg-info me-1">Lunas</span></h5>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="btn btn-success" href="{{ route('pelanggan.printinv', $invoice->id_invoice) }}" data-toggle="tooltip" title="Cetak">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr id="demo{{$invoice->id_invoice}}" class="collapse">
                                    <td colspan="7">
                                        <form method="POST" action="{{ route('pelanggan.bukti', $invoice->id_invoice) }}" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="bukti">{{ __('Upload Bukti') }}</label>
                                                <input id="bukti" type="file" class="dropify" name="bukti" data-height="100" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-lg btn-center-block col-sm-3">
                                                    Upload
                                                </button>
                                            </div>
                                        </form>
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
@section('modal')
    @foreach($invoices as $no => $invoice)
        <div class="modal" id="myModal{{$invoice->id_invoice}}">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Bukti pembayaran {{$invoice->id_invoice}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <img src="{{ asset('bukti_bayar') }}/{{ $invoice->bukti_bayar }}" width="100%">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection
