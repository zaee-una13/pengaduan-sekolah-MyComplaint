@if ($item->status === 'pending')
    <form action="{{ route('admin.pengaduan.updateStatus', $item->id) }}" method="POST" class="space-y-2">
        @csrf
        @method('PATCH')
        <select name="status" class="w-full text-xs rounded-lg border-gray-200 text-gray-800">
            <option value="pending" selected>Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
        <input type="text" name="catatan_penyerahan" value="{{ $item->catatan_penyerahan }}"
               placeholder="Catatan/Tanggapan Admin"
               class="w-full text-xs rounded-lg border-gray-200 text-gray-800">
        <button type="submit" class="w-full py-2 px-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition">SIMPAN</button>
    </form>
@else
    <div class="text-xs text-gray-400 break-words">
        <span class="font-semibold block mb-1">Status Permanen</span>
        Catatan: {{ $item->catatan_penyerahan ?? '-' }}
    </div>
@endif