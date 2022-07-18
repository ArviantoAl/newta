@extends('layouts.nowa',[
    'titlePage' => __('Tambah Perangkat'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Tambah Perangkat</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Teknisi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Perangkat</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card  box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">Tambah Perangkat</h4>
                <p class="mb-2">Isi data form berikut untuk menambahkan data perangkat.</p>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('') }}">
                    @csrf
{{--                    <div class="">--}}
                        <div class="form-group">
                            <label for="" class="form-label">Nama Perangkat</label>
                            <input class="form-control" id="" name="" placeholder="Masukkan Nama Perangkat" type="text" required autocomplete="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Lokasi</label>
                            <input class="form-control" id="" name="" placeholder="Pilih Lokasi" type="text" required autocomplete="" autofocus>
                        </div>
                            <div class="form-group">
                                <label for="" class="form-label">{{ __('') }}</label>
                                <select id="" name="" class="form-control form-select select2" data-bs-placeholder="Pilih Lokasi">
                                    <option>Pilih Lokasi BTS</option>
                                    @foreach ($ as $)
                                        <option value="{{  }}">{{  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Frekuensi</label>
                                <input class="form-control" id="" name="" placeholder="Masukkan Frekuensi" type="text" required autocomplete="" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">{{ __('') }}</label>
                                <select id="" name="" class="form-control form-select select2" data-bs-placeholder="Pilih Kategori Frekuensi">
                                    <option>Pilih Kategori Frekuensi</option>
                                    @foreach ($ as $)
                                        <option value="{{  }}">{{  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">SSID Perangkat</label>
                                <input class="form-control" id="" name="" placeholder="Masukkan SSID" type="text" required autocomplete="" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">IP Address</label>
                                <input class="form-control" id="" name="" placeholder="Masukkan IP Address" type="text" required autocomplete="" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">{{ __('') }}</label>
                                <select id="" name="" class="form-control form-select select2" data-bs-placeholder="Pilih Kategori Perangkat">
                                    <option>Pilih Kategori Perangkat</option>
                                    @foreach ($ as $)
                                        <option value="{{  }}">{{  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Status pakai radio button --}}
                            <div class="form-group">
                                <label for="" class="form-label">Keterangan</label>
                                <input class="form-control" id="" name="" placeholder="Masukkan Keterangan" type="text area" required autocomplete="" autofocus>
                            </div>
{{--                    </div>--}}
                    <button type="submit" class="btn btn-primary mt-3 mb-0">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
