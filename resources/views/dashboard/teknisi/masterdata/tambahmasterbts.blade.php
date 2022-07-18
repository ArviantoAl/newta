
            @extends('layouts.nowa',[
                'titlePage' => __('Tambah Master BTS'),
            ])
            
            @section('content')
                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1">Tambah Master BTS</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Teknisi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Master BTS</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->
            
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card  box-shadow-0 ">
                        <div class="card-header">
                            <h4 class="card-title mb-1">Form Tambah BTS</h4>
                            <p class="mb-2">Isi data form berikut untuk menambahkan BTS.</p>
                        </div>
                        <div class="card-body pt-0">
                            <form method="POST" action="{{ route('teknisi.posttambahmasterbts') }}">
                                @csrf
                                {{--                    <div class="">--}}
                                <div class="form-group">
                                    <label for="nama_Merk" class="form-label">Nama BTS</label>
                                    <input class="form-control" id="nama_Merk" name="nama_perangkat" placeholder="Masukkan Nama Merk" type="text" required autocomplete="nama_Merk" autofocus>
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

                                    <div class="form-group col-6">
                                        <label for="turunan2" class="form-label">Sambungkan ke Pelanggan</label>
                                        <select name="turunan2" id="turunan2" class="form-control form-select select2"></select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="ip2" class="form-label">IP Address</label>
                                        <input class="form-control" id="ip2" name="ip2" placeholder="Masukkan IP pelanggan" type="text" required autocomplete="ip2" autofocus>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="ip_radio2" class="form-label">IP Radio</label>
                                        <input class="form-control" id="ip_radio2" name="ip_radio2" placeholder="Masukkan IP Radio" type="text" required autocomplete="ip_radio2" autofocus>
                                    </div>
                                </div>

                                <div class="form-divider">
                                    {{ __('Alamat Pemasangan') }}
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="provinsi2" class="form-label">Provinsi</label>
                                        <select name="provinsi" id="provinsi" class="form-control form-select select2" data-bs-placeholder="Pilih Provinsi">
                                            <option>Pilih Provinsi</option>
                                            @foreach ($provinsi as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="kabupaten2" class="form-label">Kabupaten/Kota</label>
                                        <select name="kabupaten" id="kabupaten" class="form-control form-select select2"></select>
                                            @foreach ($kabupaten as $r)
                                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                            @endforeach
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

                                <div class="form-group">
                                    <label for="alamat2" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat2" placeholder="Masukkan Alamat Lengkap Pelanggan" required></textarea>
                                </div>
                                {{--                    </div>--}}
                                <button type="submit" class="btn btn-primary mt-3 mb-0">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endsection

            <script>
                $('#provinsi').change(function() {
                    var provinsiID = $(this).val();
                    if (provinsiID) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('get-kabupaten') }}?id_provinsi=" + provinsiID,
                            success: function(res) {
                                if (res) {
                                    $('#kab_ktp').empty();
                                    $('#kab_ktp').append('<option value="">Pilih Kota/Kabupaten</option>');
                                    $.each(res, function(key, value) {
                                        $('#kab_ktp').append('<option value="' + key + '">' + value + '</option>');
                                    });
                                } else {
                                    $('#kab_ktp').empty();
                                }
                            }
                        });
                    } else {
                        $('#kab_ktp').empty();
                        $('#kec_ktp').empty();
                    }
                });
            </script>

            <script src="{{ asset('/assets/plugins/parsleyjs/dist/parsley.js') }}"></script> 
<script src="{{ asset('/assets/plugins/select2/dist/js/select2.min.js') }}"></script> 
<script src="{{ asset('/assets/js/custom/string-helper.js') }}"></script> 
<script src="{{ asset('/assets/js/wilayah-dropdown.js') }}"></script> 
<script src="{{ asset('/assets/js/custom/datetime-picker.js') }}"></script>

            <script>
                $(function() { 
                 handleWilayahSelectEvent('#provinsi', '#kabupaten', '#kecamatan', '#desa'); 
                 initParsley(); 
            
                 })
            </script>