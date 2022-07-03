@extends('layouts.nowa',[
    'titlePage' => __('Edit Layanan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Edit Layanan</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Layanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Layanan</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card  box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">Form Edit Layanan</h4>
                <p class="mb-2">Ubah data baru untuk data layanan tersebut.</p>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.posteditlayanan', $layanan->id_layanan) }}">
                    @csrf
                    @method('PUT')
                    {{--                    <div class="">--}}
                    <div class="form-group">
                        <label for="kategori" class="form-label">{{ __('Kategori') }}</label>
                        <select id="kategori" name="layanan_kategori" class="form-control form-select select2" data-bs-placeholder="Pilih Kategori">
                            <option value="{{ $layanan->layanan_kategori }}">{{ $layanan->kategori->nama_kategori }}</option>
                            @foreach ($kategoris as $jenis)
                                <option value="{{ $jenis->id_kategori }}">{{ $jenis->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bts_id" class="form-label">{{ __('BTS') }}</label>
                        <select id="bts_id" name="bts_id" class="form-control form-select select2" data-bs-placeholder="Pilih BTS">
                            <option value="{{ $layanan->bts_id }}">{{ $layanan->bts->nama_bts }}</option>
                            @foreach ($btss as $bts)
                                <option value="{{ $bts->id_bts }}">{{ $bts->nama_bts }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_layanan" class="form-label">Nama Layanan</label>
                        <input class="form-control" id="nama_layanan" name="nama_layanan" value="{{ $layanan->nama_layanan }}" placeholder="Masukkan Nama Layanan" type="text" required autocomplete="nama_layanan" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="harga" class="form-label">Harga</label>
                        <input class="form-control" id="harga" name="harga" value="{{ $layanan->harga }}" placeholder="Masukkan Harga (ex. 100000)" type="number" required autocomplete="harga" autofocus>
                    </div>

                    {{--                    </div>--}}
                    <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
