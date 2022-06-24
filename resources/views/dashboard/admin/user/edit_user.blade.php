@extends('layouts.app',[
    'titlePage' => __('Edit User'),
    'sub' => ' '
])

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.postedituser', $user->id_user) }}">
            @csrf
            @method('PUT')

            <div class="card-header">
                <h4>Edit User</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="user_role">{{ __('User Role') }}</label>
                    <select class="form-control selectric" id="user_role" name="user_role">
                        <option value="{{ $id_role }}">{{ $nama_role }}</option>
                        @foreach ($roles as $jenis)
                            <option value="{{ $jenis->id_role }}">{{ $jenis->nama_role }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                    @error('name')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="username">{{ __('Username') }}</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autocomplete="username" autofocus>

                        @error('username')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
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
