<form action="{{ route('admin.deletekategori', $kategori->id_kategori) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Hapus">
        <i style="color: white" class="fa fa-trash"></i>
    </button>
</form>
