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
            <a class="btn btn-success" href="{{ route('admin.kirimsemua') }}">
                Kirim Invoice Bulan Ini
            </a>
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
                                <th>Total Tagihan</th>
                                <th>PPN</th>
                                <th>Status Terakhir</th>
                                <th colspan="3">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($invoices as $no => $invoice)
                                <tr>
                                    <td>{{ $invoice->id_invoice }}</td>
                                    <td>{{ $invoice->pelanggan->name }}</td>
                                    <td>{{ $invoice->tgl_terbit }}</td>
                                    <td>{{ $invoice->tgl_tempo }}</td>
                                    <td>{{ rupiah($invoice->tagihan) }}</td>
                                    <td>
                                        <input id="ppn" type="checkbox" data-id="{{ $invoice->id_invoice }}" {{ $invoice->ppn == 1 ? 'checked' : '' }}>
                                    </td>
                                    @if($invoice->status_id == 6)
                                        <td>
                                            <h5><span class="badge badge-pill bg-warning me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                    @elseif($invoice->status_id == 7)
                                        <td>
                                            <h5><span class="badge badge-pill bg-warning me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal{{$invoice->id_invoice}}" data-toggle="tooltip" title="Lihat Bukti Bayar">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('admin.approvepembayaran', $invoice->id_invoice) }}" data-toggle="tooltip" title="Setujui">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <a class="btn btn-danger" href="{{ route('admin.tolakpembayaran', $invoice->id_invoice) }}" data-toggle="tooltip" title="Tolak">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        </td>
                                    @elseif($invoice->status_id == 8)
                                        <td>
                                            <h5><span class="badge badge-pill bg-success me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                    @elseif($invoice->status_id == 9)
                                        <td>
                                            <h5><span class="badge badge-pill bg-danger me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                    @endif
{{--                                    <td>--}}
{{--                                        <a class="btn btn-warning" role="button" id="detail" data-id="{{ $invoice->id_invoice }}" data-toggle="tooltip" title="detail">--}}
{{--                                            <i class="fa fa-plus"></i>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
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
@section('modal2')
    <div class="modal" id="detailmodal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Detail Invoice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $(function () {
                $('#detail').click(function(){
                    let id_invoice = $(this).data('id');
                    console.log(id_invoice);
                    $.ajax({
                        type: "POST",
                        url: "{{route('getDetail')}}",
                        data: {id_invoice: id_invoice},
                        cache: false,
                        success: function (msg) {
                            $('.modal-body').html(msg);
                            // Display Modal
                            $('#detailmodal').modal('show');
                        },
                        error: function (data) {
                            console.log('error:', data);
                        }
                    })
                })
            })
        });
    </script>
@endsection
@section('modal')
    @foreach($invoices as $no => $invoice)
        <div class="modal" id="myModal{{$invoice->id_invoice}}">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Bukti pembayaran {{$invoice->id_invoice}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
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
