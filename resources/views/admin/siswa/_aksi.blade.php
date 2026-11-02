<div class="flex items-center gap-2">
    <a href="{{ route('admin.siswa.edit', $s->id) }}"
       class="px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
        Edit
    </a>
    <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
          onsubmit="return confirm('Hapus akun {{ e($s->name) }}? Semua pengaduan milik siswa ini juga akan terhapus dan tidak dapat dikembalikan.')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
            Hapus
        </button>
    </form>
</div>