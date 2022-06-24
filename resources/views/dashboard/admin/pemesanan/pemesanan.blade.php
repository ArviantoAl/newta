@extends('layouts.nowa')

@section('content')
    <!-- main-content -->
    <div class="main-content app-content">

        <!-- container -->
        <div class="main-container container-fluid">

            <!-- breadcrumb -->
            <div class="breadcrumb-header justify-content-between">
                <div class="left-content">
                    <span class="main-content-title mg-b-0 mg-b-lg-1">EMPTY PAGE</span>
                </div>
                <div class="justify-content-center mt-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Pages</a></li>
                        <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Empty Page</li>
                    </ol>
                </div>
            </div>
            <!-- /breadcrumb -->

            <!-- row -->
            <div class="row">
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="main-content-label mg-b-5">
                                Left Label Alignment
                            </div>
                            <p class="mg-b-20">It is Very Easy to Customize and it uses in your website apllication.</p>
                            <div class="pd-30 pd-sm-20">
                                <div class="panel panel-primary">
                                    <div class=" tab-menu-heading mb-2 border-bottom-0">
                                        <div class="tabs-menu1">
                                            <ul class="nav panel-tabs">
                                                <li class="me-2"><a href="#tab5" class="active" data-bs-toggle="tab">Pelanggan Lama</a></li>
                                                <li><a href="#tab6" data-bs-toggle="tab" class="">Pelanggan Baru</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body border-0 p-3">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab5">
                                                <form id="form1" action="{{ route('pelanggan_lama') }}">
                                                    <div class="form-group">
                                                        <label for="user" class="form-label">Cari User</label>
                                                        <select name="user" id="user" class="form-control form-select select2" data-bs-placeholder="Pilih User">
                                                            <option>Pilih User</option>
                                                            @foreach ($user as $u)
                                                                <option value="{{ $u->id_user }}">{{ $u->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="kategori" class="form-label">Kategori</label>
                                                            <select name="kategori" id="kategori" class="form-control form-select select2" data-bs-placeholder="Pilih Kategori">
                                                                <option>Pilih Kategori</option>
                                                                @foreach ($kategori as $k)
                                                                    <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="layanan" class="form-label">Layanan</label>
                                                            <select name="layanan" id="layanan" class="form-control form-select select2"></select>
                                                        </div>
                                                    </div>

                                                    <div class="form-divider">
                                                        {{ __('Alamat Pemasangan') }}
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="provinsi" class="form-label">Provinsi</label>
                                                            <select name="provinsi" id="provinsi" class="form-control form-select select2" data-bs-placeholder="Pilih Provinsi">
                                                                <option>Pilih Provinsi</option>
                                                                @foreach ($provinsi as $p)
                                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                            <select name="kabupaten" id="kabupaten" class="form-control form-select select2"></select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                                            <select name="kecamatan" id="kecamatan" class="form-control form-select select2"></select>
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="desa" class="form-label">Desa/Kelurahan</label>
                                                            <select name="desa" id="desa" class="form-control form-select select2"></select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="alamat" class="form-label">Alamat</label>
                                                        <textarea class="form-control" id="alamat" placeholder="Masukkan Alamat Lengkap Pelanggan" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5">Pesan</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab6">
                                                <form id="form2" action="{{ route('pelanggan_baru') }}">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Nama</label>
                                                        <input class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap" type="text" required autocomplete="name" autofocus>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input class="form-control" id="email" name="email" placeholder="Masukkan Email" type="email" required autocomplete="email" autofocus>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label for="username" class="form-label">Username</label>
                                                            <input class="form-control" id="username" name="username" placeholder="Masukkan Username" type="text" required autocomplete="username" autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="no_hp" class="form-label">No HP</label>
                                                        <input class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan Nomor HP" type="text" required autocomplete="no_hp" autofocus>
                                                    </div>

                                                    <div class="form-divider">
                                                        {{ __('Pesan Langganan') }}
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="kategori" class="form-label">Kategori</label>
                                                            <select name="kategori" id="kategori2" class="form-control form-select select2" data-bs-placeholder="Pilih Kategori">
                                                                <option>Pilih Kategori</option>
                                                                @foreach ($kategori as $k)
                                                                    <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="layanan" class="form-label">Layanan</label>
                                                            <select name="layanan" id="layanan2" class="form-control form-select select2"></select>
                                                        </div>
                                                    </div>

                                                    <div class="form-divider">
                                                        {{ __('Alamat Pemasangan') }}
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="provinsi" class="form-label">Provinsi</label>
                                                            <select name="provinsi" id="provinsi2" class="form-control form-select select2" data-bs-placeholder="Pilih Provinsi">
                                                                <option>Pilih Provinsi</option>
                                                                @foreach ($provinsi as $p)
                                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                            <select name="kabupaten" id="kabupaten2" class="form-control form-select select2"></select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                                            <select name="kecamatan" id="kecamatan2" class="form-control form-select select2"></select>
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="desa" class="form-label">Desa/Kelurahan</label>
                                                            <select name="desa" id="desa2" class="form-control form-select select2"></select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="alamat" class="form-label">Alamat</label>
                                                        <textarea class="form-control" id="alamat2" placeholder="Masukkan Alamat Lengkap Pelanggan" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5">Register</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->

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
                $("#form1").submit(function (e) {
                    e.preventDefault();
                    var id_user = $('#user').val();
                    var id_layanan = $('#layanan').val();
                    var id_provinsi = $('#provinsi').val();
                    var id_kabupaten = $('#kabupaten').val();
                    var id_kecamatan = $('#kecamatan').val();
                    var id_desa = $('#desa').val();
                    var id_alamat = $('#alamat').val();
                    console.log(id_alamat);
                    $.ajax({
                        type: "POST",
                        url: "{{route('pelanggan_lama')}}",
                        data: {
                            id_user: id_user,
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
                            window.location.href = "/pemesanan";
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    })
                })


                $('#kategori2').on('change', function () {
                    var id_kategori2 = $('#kategori2').val();
                    console.log(id_kategori2);
                    $.ajax({
                        type: "POST",
                        url: "{{route('getLayanan')}}",
                        data: {id_kategori: id_kategori2},
                        cache: false,
                        success: function (msg) {
                            $('#layanan2').html(msg);
                        },
                        error: function (data) {
                            console.log('error:', data);
                        }
                    })
                })
                $('#layanan2').on('change',function (){
                    var id_layanan2 = $('#layanan2').val();
                    console.log(id_layanan2);
                })
                $('#provinsi2').on('change',function (){
                    var id_provinsi2 = $('#provinsi2').val();
                    console.log(id_provinsi2)
                    $.ajax({
                        type : "POST",
                        url : "{{route('getKabupaten')}}",
                        data : {id_provinsi:id_provinsi2},
                        cache : false,
                        success: function (msg){
                            $('#kabupaten2').html(msg);
                            $('#kecamatan2').html('');
                            $('#desa2').html('');
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#kabupaten2').on('change',function (){
                    var id_kabupaten2 = $('#kabupaten2').val();
                    console.log(id_kabupaten2);
                    $.ajax({
                        type : "POST",
                        url : "{{route('getKecamatan')}}",
                        data : {id_kabupaten:id_kabupaten2},
                        cache : false,
                        success: function (msg){
                            $('#kecamatan2').html(msg);
                            $('#desa2').html('');
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#kecamatan2').on('change',function (){
                    var id_kecamatan2 = $('#kecamatan2').val();
                    console.log(id_kecamatan2);
                    $.ajax({
                        type : "POST",
                        url : "{{route('getDesa')}}",
                        data : {id_kecamatan:id_kecamatan2},
                        cache : false,
                        success: function (msg){
                            $('#desa2').html(msg);
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#desa2').on('change',function (){
                    var id_desa2 = $('#desa2').val();
                    console.log(id_desa2);
                })
                $("#form2").submit(function (e) {
                    e.preventDefault();
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var username = $('#username').val();
                    var no_hp = $('#no_hp').val();
                    var id_layanan = $('#layanan2').val();
                    var id_provinsi = $('#provinsi2').val();
                    var id_kabupaten = $('#kabupaten2').val();
                    var id_kecamatan = $('#kecamatan2').val();
                    var id_desa = $('#desa2').val();
                    var id_alamat = $('#alamat2').val();
                    console.log(id_alamat);
                    $.ajax({
                        type: "POST",
                        url: "{{route('pelanggan_baru')}}",
                        data: {
                            name: name,
                            email: email,
                            username: username,
                            no_hp: no_hp,
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
                            window.location.href = "/pemesanan";
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
