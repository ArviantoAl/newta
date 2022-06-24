@extends('layouts.app',[
    'titlePage' => __('Tambah Kategori'),
    'sub' => ' '
])

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.postkategori') }}">
            @csrf

            <div class="card-header">
                <h4>Tambah Kategori</h4>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label for="nama_kategori">{{ __('Name') }}</label>
                    <input id="nama_kategori" type="text" class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori" value="{{ old('nama_kategori') }}" required autocomplete="nama_kategori" autofocus>
                    @error('nama_kategori')
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
