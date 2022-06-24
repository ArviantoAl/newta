@extends('layouts.app',[
    'titlePage'=>__('Pemesanan'),
    'sub' => ' '
])

@section('content')
    <div class="card">
        <form id="form" method="POST" action="{{ route('postpemesanan') }}">
            @csrf

            <div class="card-header">
                <h4>Form Pemesanan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="kategori">{{ __('Kategori') }}</label>
                        <select class="form-control selectric" id="kategori" name="id_kategori">
                            <option>Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="layanan">{{ __('Layanan') }}</label>
                        <select class="form-control selectric" id="layanan" name="id_layanan"></select>
                    </div>
                </div>

                <div class="form-divider">
                    {{ __('Alamat Pemasangan') }}
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="provinsi">{{ __('Provinsi') }}</label>
                        <select class="form-control selectric" id="provinsi" name="id_provinsi">
                            <option>Pilih Provinsi</option>
                            @foreach ($provincies as $provinsi)
                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="kabupaten">{{ __('Kabupaten/Kota') }}</label>
                        <select class="form-control selectric" id="kabupaten" name="id_kabupaten"></select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="kabupaten">{{ __('Kecamatan') }}</label>
                        <select class="form-control selectric" id="kecamatan" name="id_kecamatan"></select>
                    </div>
                    <div class="form-group col-6">
                        <label for="kabupaten">{{ __('Kelurahan/Desa') }}</label>
                        <select class="form-control selectric" id="desa" name="id_desa"></select>
                    </div>
                </div>

                <label for="alamat">{{ __('Alamat Lengkap') }}</label>
                <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="alamat"></textarea>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Create
                    </button>
                </div>

            </div>
        </form>
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
