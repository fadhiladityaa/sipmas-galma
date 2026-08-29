<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gama-text">📋 Riwayat Pengajuan</h1>
                        <p class="text-sm text-gama-gray mt-1">Daftar pengajuan yang sudah diterbitkan atau ditolak</p>
                    </div>
                    <span class="text-sm text-gama-gray">
                        Total: <strong class="text-gama-text">{{ $applications->total() }}</strong> pengajuan
                    </span>
                </div>

                <!-- ============================================= -->
                <!-- FILTER                                       -->
                <!-- ============================================= -->
                <form method="GET" action="{{ route('staff.riwayat') }}"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label for="service_id" class="block text-xs font-medium text-gama-gray">Jenis Surat</label>
                        <select name="service_id" id="service_id"
                            class="mt-1 w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent text-sm">
                            <option value="">Semua</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-medium text-gama-gray">Status</label>
                        <select name="status" id="status"
                            class="mt-1 w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent text-sm">
                            <option value="">Semua</option>
                            <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Diterbitkan
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="block text-xs font-medium text-gama-gray">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                            class="mt-1 w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent text-sm">
                    </div>

                    <div>
                        <label for="date_to" class="block text-xs font-medium text-gama-gray">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                            class="mt-1 w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent text-sm">
                    </div>

                    <div class="sm:col-span-2 lg:col-span-4 flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-gama-primary hover:bg-[#1f3320] text-white rounded-lg text-sm transition">
                            🔍 Filter
                        </button>
                        <a href="{{ route('staff.riwayat') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm transition">
                            ↺ Reset
                        </a>
                    </div>
                </form>

                <!-- ============================================= -->
                <!-- TABEL RIWAYAT                                -->
                <!-- ============================================= -->
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
                            @forelse ($applications as $app)
                                <tr class="border-b border-gray-100 hover:bg-gama-bg/30 transition">
                                    <td class="px-4 py-3 font-mono text-sm">{{ $app->application_number }}</td>
                                    <td class="px-4 py-3">{{ $app->user->name }}</td>
                                    <td class="px-4 py-3">{{ $app->service->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs
                                            @if ($app->status == 'issued') bg-green-100 text-green-700
                                            @elseif($app->status == 'rejected') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ str_replace('_', ' ', ucfirst($app->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $app->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('staff.application.detail', $app->id) }}"
                                            class="text-gama-accent hover:text-gama-primary text-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gama-gray">
                                        <div class="text-4xl mb-2">📭</div>
                                        <p>Belum ada pengajuan yang diterbitkan atau ditolak.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $applications->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
