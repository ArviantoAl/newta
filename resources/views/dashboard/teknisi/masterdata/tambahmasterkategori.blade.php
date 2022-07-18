            @extends('layouts.nowa',[
                'titlePage' => __('Tambah Master Kategori'),
            ])
            
            @section('content')
                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1">Tambah Master Kategori</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Teknisi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Master Kategori</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->
            
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card  box-shadow-0 ">
                        <div class="card-header">
                            <h4 class="card-title mb-1">Form Tambah Kategori</h4>
                            <p class="mb-2">Isi data form berikut untuk menambahkan Kategori (merk).</p>
                        </div>
                        <div class="card-body pt-0">
                            <form method="POST" action="{{ route('teknisi.posttambahmasterkategori') }}">
                                @csrf
                                {{--                    <div class="">--}}
                                <div class="form-group">
                                    <label for="nama_Merk" class="form-label">Nama Merk</label>
                                    <input class="form-control" id="nama_Merk" name="nama_perangkat" placeholder="Masukkan Nama Merk" type="text" required autocomplete="nama_Merk" autofocus>
                                </div>
                                {{--                    </div>--}}
                                <button type="submit" class="btn btn-primary mt-3 mb-0">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endsection
            