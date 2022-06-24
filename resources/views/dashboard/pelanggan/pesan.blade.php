@extends('dashboard.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Pesan Layanan') }}</div>

                    <div class="card-body">
                        <div class="alert alert-success" style="display:none"></div>
                        <form id="form" method="POST" action="{{ route('postpemesanan') }}">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label text-md-center">{{ __('Pilih Layanan') }}</label>
                            </div>

                            <div class="row mb-3">
                                <label for="kategori" class="col-md-4 col-form-label text-md-end">{{ __('Kategori') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="kategori" name="id_kategori">
                                        <option>Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>

                                    @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="layanan" class="col-md-4 col-form-label text-md-end">{{ __('Layanan') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="layanan" name="id_layanan"></select>

                                    @error('layanan')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label text-md-center">{{ __('Alamat Pemasangan') }}</label>
                            </div>

                            <div class="row mb-3">
                                <label for="provinsi" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="provinsi" name="id_provinsi">
                                        <option>Pilih Provinsi</option>
                                        @foreach ($provincies as $provinsi)
                                            <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('provinsi')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kabupaten" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten/Kota') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="kabupaten" name="id_kabupaten"></select>

                                    @error('kabupaten')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kecamatan" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="kecamatan" name="id_kecamatan"></select>

                                    @error('kecamatan')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="desa" class="col-md-4 col-form-label text-md-end">{{ __('Kelurahan/Desa') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="desa" name="id_desa"></select>

                                    @error('desa')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat Lengkap') }}</label>

                                <div class="col-md-6">
                                    <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="alamat" autofocus></textarea>

                                    @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        {{ __('Pesan') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $(function () {
                $('#kategori').on('change', function () {
                    var id_kategori = $('#kategori').val();
                    console.log(id_kategori);
                    $.ajax({
                        type: "POST",
                        url: "{{route('getLayanan')}}",
                        data: {id_kategori: id_kategori},
                        cache: false,
                        success: function (msg) {
                            $('#layanan').html(msg);
                        },
                        error: function (data) {
                            console.log('error:', data);
                        }
                    })
                })
                $('#layanan').on('change',function (){
                    var id_layanan = $('#layanan').val();
                    console.log(id_layanan);
                })
                $('#provinsi').on('change',function (){
                    var id_provinsi = $('#provinsi').val();
                    console.log(id_provinsi)
                    $.ajax({
                        type : "POST",
                        url : "{{route('getKabupaten')}}",
                        data : {id_provinsi:id_provinsi},
                        cache : false,
                        success: function (msg){
                            $('#kabupaten').html(msg);
                            $('#kecamatan').html('');
                            $('#desa').html('');
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#kabupaten').on('change',function (){
                    var id_kabupaten = $('#kabupaten').val();
                    console.log(id_kabupaten);
                    $.ajax({
                        type : "POST",
                        url : "{{route('getKecamatan')}}",
                        data : {id_kabupaten:id_kabupaten},
                        cache : false,
                        success: function (msg){
                            $('#kecamatan').html(msg);
                            $('#desa').html('');
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#kecamatan').on('change',function (){
                    var id_kecamatan = $('#kecamatan').val();
                    console.log(id_kecamatan);
                    $.ajax({
                        type : "POST",
                        url : "{{route('getDesa')}}",
                        data : {id_kecamatan:id_kecamatan},
                        cache : false,
                        success: function (msg){
                            $('#desa').html(msg);
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#desa').on('change',function (){
                    var id_desa = $('#desa').val();
                    console.log(id_desa);
                })
                $("#form").submit(function (e) {
                    e.preventDefault();
                    var id_layanan = $('#layanan').val();
                    var id_provinsi = $('#provinsi').val();
                    var id_kabupaten = $('#kabupaten').val();
                    var id_kecamatan = $('#kecamatan').val();
                    var id_desa = $('#desa').val();
                    var id_alamat = $('#alamat').val();
                    console.log(id_alamat);
                    $.ajax({
                        type: "POST",
                        url: "{{route('postpemesanan')}}",
                        data: {
                            id_layanan: id_layanan,
                            id_provinsi: id_provinsi,
                            id_kabupaten: id_kabupaten,
                            id_kecamatan: id_kecamatan,
                            id_desa: id_desa,
                            id_alamat: id_alamat
                        },
                        cache: false,
                        success: function (data) {
                            console.log('success: ' + data);
                            window.location.href = "/pelanggan/data_langganan";
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    })
                })
            })
        });
    </script>
@endsection
