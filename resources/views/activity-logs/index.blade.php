<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Riwayat Aktivitas Sistem
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <div class="mb-6">
                <h3 class="text-lg font-semibold">
                    Audit Log
                </h3>

                <p class="text-sm text-gray-500">
                    Menampilkan riwayat aktivitas pengguna dalam mengelola kategori, barang, dan peminjaman.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left">Waktu</th>
                            <th class="border px-4 py-2 text-left">User</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                            <th class="border px-4 py-2 text-left">Modul</th>
                            <th class="border px-4 py-2 text-left">Deskripsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($activityLogs as $log)
                            <tr>
                                <td class="border px-4 py-2">
                                    {{ $log->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $log->user->name ?? 'System' }}
                                </td>

                                <td class="border px-4 py-2">
                                    @if($log->action === 'create')
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                            CREATE
                                        </span>
                                    @elseif($log->action === 'update')
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                            UPDATE
                                        </span>
                                    @elseif($log->action === 'delete')
                                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                                            DELETE
                                        </span>
                                    @elseif($log->action === 'return')
                                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                            RETURN
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                            {{ strtoupper($log->action) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $log->module ?? '-' }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $log->description }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-10 text-center text-gray-500">
                                    <p class="font-semibold">Belum ada aktivitas yang tercatat.</p>
                                    <p class="text-sm mt-1">
                                        Aktivitas akan muncul setelah admin atau staff menambah, mengubah, atau menghapus data.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $activityLogs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
