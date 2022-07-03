@extends('layouts.nowa',[
    'titlePage' => __('Daftar User'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar User</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar User</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mg-b-0 text-md-nowrap">
                            <thead style="text-align: center">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($users as $no => $user)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role->nama_role }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    @if($user->status == '0')
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-warning me-1">On Progress</span>
                                            </h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('admin.edituser', $user->id_user) }}" data-toggle="tooltip" title="Aktif">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        </td>
                                    @elseif($user->status == '1')
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-success me-1">Aktif</span>
                                            </h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" href="{{ route('admin.edituser', $user->id_user) }}" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    @endif
                                    <td>
                                        <form action="{{ route('admin.deleteuser', $user->id_user) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger" type="submit" data-toggle="tooltip" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
