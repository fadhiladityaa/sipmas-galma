<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h1 class="text-2xl font-bold text-gama-text mb-4">Semua Pengajuan</h1>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gama-bg">
                            <tr>
                                <th class="px-4 py-2 text-left">No. Pengajuan</th>
                                <th class="px-4 py-2 text-left">Pemohon</th>
                                <th class="px-4 py-2 text-left">Jenis Surat</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3">{{ $app->application_number }}</td>
                                    <td class="px-4 py-3">{{ $app->user->name }}</td>
                                    <td class="px-4 py-3">{{ $app->service->name }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs
                                            @if ($app->status == 'menunggu_rt') bg-yellow-100 text-yellow-700
                                            @elseif($app->status == 'disetujui_rt') bg-green-100 text-green-700
                                            @elseif($app->status == 'ditolak_rt') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ str_replace('_', ' ', ucfirst($app->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $app->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('rt.application.detail', $app->id) }}"
                                            class="text-gama-accent hover:text-gama-primary text-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gama-gray">
                                        Belum ada pengajuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
