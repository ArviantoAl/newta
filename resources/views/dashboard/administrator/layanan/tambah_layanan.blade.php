@extends('layouts.app',[
    'titlePage' => __('Tambah Layanan'),
    'sub' => ' '
])

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('administrator.postlayanan') }}">
            @csrf

            <div class="card-header">
                <h4>Tambah Layanan</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="kategori">{{ __('Kategori') }}</label>
                    <select class="form-control selectric" id="kategori" name="layanan_kategori">
                        <option>- Pilih -</option>
                        @foreach ($kategoris as $jenis)
                            <option value="{{ $jenis->id_kategori }}">{{ $jenis->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nama_layanan">{{ __('Nama Layanan') }}</label>
                    <input id="nama_layanan" type="text" class="form-control @error('nama_layanan') is-invalid @enderror" name="nama_layanan" value="{{ old('nama_layanan') }}" required autocomplete="nama_layanan" autofocus>
                    @error('nama_layanan')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga">{{ __('Harga') }}</label>
                    <input id="harga" type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}" required autocomplete="harga" autofocus>

                    @error('harga')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Create
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
