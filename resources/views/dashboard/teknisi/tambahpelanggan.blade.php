@extends('layouts.nowa',[
    'titlePage' => __('Tambah Pelanggan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Tambah Pelanggan</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Teknisi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Pelanggan</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card  box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">Form Tambah Pelanggan</h4>
                <p class="mb-2">Isi data form berikut untuk menambahkan Pelanggan.</p>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('teknisi.posttambahpelanggan') }}">
                    @csrf
                    {{--                    <div class="">--}}
                    <div class="form-group">
                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                        <input class="form-control" id="nama_pelanggan" name="nama_perangkat" placeholder="Masukkan Nama pelanggan" type="text" required autocomplete="nama_pelanggan" autofocus>
                    </div>
                    {{-- <div class="row">
                        <div class="form-group col-6">
                            <label for="bts2" class="form-label">BTS</label>
                            <select name="bts2" id="bts2" class="form-control form-select select2" data-bs-placeholder="Pilih BTS">
                                <option>Pilih BTS</option>
                                @foreach ($bts as $b)
                                    <option value="{{ $b->id_bts }}">{{ $b->nama_bts }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="row">
                            <div class="form-group">
                                <label for="bts2" class="form-label">BTS</label>
                                <select name="bts2" id="bts2" class="form-control form-select select2" data-bs-placeholder="Pilih BTS">
                                    <option>Pilih BTS</option>
                                    {{-- @foreach ($bts as $b)
                                        <option value="{{ $b->id_bts }}">{{ $b->nama_bts }}</option>
                                    @endforeach --}}
                                </select>

                        <div class="row">
                                <div class="form-group">
                                     <label for="" class="form-label">Pelanggan</label>
                                    <select name="" id="" class="form-control form-select select2" data-bs-placeholder="Pilih BTS">
                                        <option>Pilih Pelanggan</option>
                                            {{-- @foreach ($bts as $b)
                                                <option value="{{ $b->id_bts }}">{{ $b->nama_bts }}</option>
                                            @endforeach --}}
                                    </select>
                        

                    {{-- <div class="form-divider">
                        {{ __('Alamat Pemasangan') }}
                    </div> --}}

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="provinsi2" class="form-label">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control form-select select2" data-bs-placeholder="Pilih Provinsi">
                                <option>Pilih Provinsi</option>
                                {{-- @foreach ($provinsi as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label for="kabupaten2" class="form-label">Kabupaten/Kota</label>
                            <select name="kabupaten" id="kabupaten" class="form-control form-select select2"></select>
                                {{-- @foreach ($kabupaten as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach --}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="kecamatan2" class="form-label">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan2" class="form-control form-select select2"></select>
                                        {{-- @foreach ($kecamatan as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach --}}
                        </div>

                        <div class="form-group col-6">
                            <label for="desa2" class="form-label">Desa/Kelurahan</label>
                            <select name="desa" id="desa2" class="form-control form-select select2"></select>
                                {{-- @foreach ($desa as $v)
                                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                                @endforeach --}}
                        </div>
                        </div>

                        <div class="form-group ">
                            <label for="detail_alamat" class="form-label">Detail Alamat</label>
                            <textarea class="form-control" id="detail_alamat" placeholder="Masukkan Alamat Lengkap Pelanggan" required></textarea>
                        </div>

                        <div class="form-group ">
                            <label for="alamat_pasang" class="form-label">Alamat Pasang</label>
                            <textarea class="form-control" id="alamat_pasang" placeholder="Masukkan Alamat Lengkap Pelanggan" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="frekuensi" class="form-label">Frekuensi</label>
                            <select name="frekuensi" id="frekuensi" class="form-control form-select select2" data-bs-placeholder="Pilih Frekuensi">
                                <option>Pilih Frekuensi</option>
                                {{-- @foreach ($frekuensi as $fr)
                                    <option value="{{ $fr->id }}">{{ $fr->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        
                            <div class="form-group">
                                <label for="ssid" class="form-label">SSID</label>
                                <input class="form-control" id="ssid" name="ssid" placeholder="Masukkan SSID pelanggan" type="text" required autocomplete="ssid" autofocus>
                        

                        <div class="row">
                            <div class="form-group">
                                 <label for="ip" class="form-label">IP Address</label>
                                 <input class="form-control" id="ip" name="ip" placeholder="Masukkan ip pelanggan" type="text" required autocomplete="ip" autofocus>
                            </div>
                        
                        
                            <div class="form-group col-6">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan latitude longitude" type="text" required autocomplete="lokasi" autofocus>
                            </div>
                            

                        {{-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Default radio
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                              Default checked radio
                            </label>
                          </div> --}}
                    

                                       </div>
                    
                    <div class="form-group col-6">
                    <button type="submit" class="btn btn-primary mt-3 mb-0">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
