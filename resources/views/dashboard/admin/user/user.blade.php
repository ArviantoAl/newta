@extends('layouts.app',[
    'titlePage' => __('Daftar User'),
    'sub' => ' '
])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Semua User</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th colspan="2">Action</th>
                            </thead>
                            <tbody>
                            @foreach ($users as $no => $user)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role->nama_role }}</td>
                                    <td>{{ $user->alamat }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('admin.edituser', $user->id_user) }}">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.deleteuser', $user->id_user) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger" type="submit">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-success" href="{{ route('admin.tambahuser') }}">Tambah User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
