@extends('layouts.app',[
    'titlePage' => __('Edit Layanan'),
    'sub' => ' '
])

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('administrator.posteditlayanan', $layanan->id_layanan) }}">
            @csrf
            @method('PUT')

            <div class="card-header">
                <h4>Edit Layanan</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="kategori">{{ __('Kategori') }}</label>
                    <select class="form-control selectric" id="kategori" name="layanan_kategori">
                        <option value="{{ $id_kategori }}">{{ $nama_kategori }}</option>
                        @foreach ($kategoris as $jenis)
                            <option value="{{ $jenis->id_kategori }}">{{ $jenis->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nama_layanan">{{ __('Nama Layanan') }}</label>
                    <input id="nama_layanan" type="text" class="form-control @error('nama_layanan') is-invalid @enderror" name="nama_layanan" value="{{ $layanan->nama_layanan }}" required autocomplete="nama_layanan" autofocus>
                    @error('nama_layanan')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga">{{ __('Harga') }}</label>
                    <input id="harga" type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ $layanan->harga }}" required autocomplete="harga" autofocus>

                    @error('harga')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Submit
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
