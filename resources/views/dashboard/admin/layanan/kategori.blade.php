@extends('layouts.app',[
    'titlePage' => __('Daftar Kategori'),
    'sub' => ' '
])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Kategori</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach ($kategoris as $no => $kategori)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $kategori->nama_kategori }}</td>
                                    <td>
                                        <form action="{{ route('admin.deletekategori', $kategori->id_kategori) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger" type="submit">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-success" href="{{ route('admin.tambahkategori') }}">Tambah Kategori</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
