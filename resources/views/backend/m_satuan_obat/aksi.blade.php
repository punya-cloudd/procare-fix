<a href="{{ route('satuan-obat.edit', $satuan_obat->id) }}" class="btn btn-warning btn-sm">
    <i class="fas fa-edit"></i> Edit
</a>

<form action="{{ route('satuan-obat.destroy', $satuan_obat->id) }}" method="POST" style="display:inline;"
      onsubmit="return confirmDelete(event);">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i> Hapus
    </button>
</form>
