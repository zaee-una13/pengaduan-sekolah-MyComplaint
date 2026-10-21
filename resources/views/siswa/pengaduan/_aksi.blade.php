@if ($item->status === 'pending')
    <div class="flex items-center gap-2">
        <a href="{{ route('siswa.pengaduan.edit', $item->id) }}"
           class="px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
            Edit
        </a>
        <form action="{{ route('siswa.pengaduan.destroy', $item->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                Hapus
            </button>
        </form>
    </div>
@else
    <span class="text-xs text-gray-400">Terkunci</span>
@endif