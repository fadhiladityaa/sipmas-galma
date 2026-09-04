<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsAppJob;
use App\Models\Application;
use App\Models\Letter;
use App\Models\Service;
use App\Services\SettingService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Dashboard Staff
     */
    public function dashboard()
    {
        $pending = Application::where('status', 'disetujui_rt')
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->get();

        $inProgress = Application::where('status', 'in_progress')
            ->where('staff_id', Auth::id())
            ->with(['user', 'service'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $completed = Application::where('status', 'issued')
            ->with(['user', 'service'])
            ->orderBy('issued_at', 'desc')
            ->limit(10)
            ->get();

        $stats = [
            'pending' => Application::where('status', 'disetujui_rt')->count(),
            'in_progress' => Application::where('status', 'in_progress')->count(),
            'completed' => Application::where('status', 'issued')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
        ];

        return view('staff.dashboard', compact('pending', 'inProgress', 'completed', 'stats'));
    }

    /**
 * Download dokumen (KTP/KK) warga
 */
    public function downloadDokumen($id, $type)
    {
        $application = Application::with(['user'])->findOrFail($id);
        $user = $application->user;

        // Tentukan path berdasarkan type
        if ($type === 'ktp') {
            $path = $user->ktp_path;
            $filename = 'KTP-' . $user->name . '.jpg';
        } elseif ($type === 'kk') {
            $path = $user->kk_path;
            $filename = 'KK-' . $user->name . '.jpg';
        } else {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $fullPath = Storage::disk('public')->path($path);
        return response()->download($fullPath, $filename);
    }

    /**
     * Daftar Pengajuan
     */
    public function applications(Request $request)
    {
        $query = Application::with(['user', 'service']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['disetujui_rt', 'in_progress']);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('staff.applications', compact('applications'));
    }

    /**
     * Detail Pengajuan
     */
    public function detail($id)
    {
        $application = Application::with(['user', 'service', 'documents', 'letter'])
            ->whereIn('status', ['disetujui_rt', 'in_progress', 'issued'])
            ->findOrFail($id);

        $letter = Letter::where('application_id', $application->id)->first();
        $user = $application->user;

        return view('staff.detail', compact('application', 'letter', 'user'));
    }

    /**
     * Mulai Proses Pengajuan
     */
    public function process(Request $request, $id)
    {
        $application = Application::where('status', 'disetujui_rt')->findOrFail($id);
        $application->status = 'in_progress';
        $application->staff_id = Auth::id();
        $application->processed_at = now();
        $application->save();

        return redirect()->route('staff.application.detail', $id)
            ->with('success', '✅ Pengajuan mulai diproses. Silakan upload surat yang sudah jadi.');
    }

    /**
     * Upload Surat (PDF)
     */
    public function uploadSurat(Request $request, $id)
    {
        $application = Application::where('status', 'in_progress')
            ->where('staff_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'surat_pdf' => 'required|file|mimes:pdf|max:5120',
            'letter_number' => 'nullable|string|max:50',
        ]);

        // Generate nomor surat
        $letterNumber = $request->letter_number;
        if ($letterNumber) {
            $fullLetterNumber = '148.3/' . $letterNumber . '/GLM';
        } else {
            $lastNumber = Letter::max('letter_number') ?? 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $fullLetterNumber = '148.3/' . $newNumber . '/GLM';
            $letterNumber = $newNumber;
        }

        // Simpan file PDF
        $file = $request->file('surat_pdf');
        $path = $file->store('surat/uploaded', 'public');

        // Simpan ke tabel letters
        $letter = Letter::updateOrCreate(
            ['application_id' => $application->id],
            [
                'staff_id' => Auth::id(),
                'letter_number' => $letterNumber,
                'content' => null,
                'pdf_path' => $path,
                'issued_at' => null,
            ]
        );

        return redirect()->route('staff.application.detail', $id)
            ->with('success', '✅ Surat berhasil diupload. Klik "Terbitkan" untuk mengirim ke warga.');
    }

    /**
     * Terbitkan Surat (Kirim ke Warga)
     */
    public function terbitkan($id)
    {
        $application = Application::where('status', 'in_progress')
            ->where('staff_id', Auth::id())
            ->with(['user', 'service', 'letter'])
            ->findOrFail($id);

        $letter = $application->letter;

        if (!$letter || !$letter->pdf_path) {
            return back()->with('error', '⚠️ Surat belum diupload. Upload surat terlebih dahulu.');
        }

        // Update status
        $application->status = 'issued';
        $application->issued_at = now();
        $application->save();

        // Update letter
        $letter->issued_at = now();
        $letter->save();

        // =============================================
        // KIRIM NOTIFIKASI KE WARGA
        // =============================================
        try {
            $wa = app(WhatsAppService::class);

            $phoneNumber = $application->user->nomor_hp;
            $pdfPath = $letter->pdf_path;

            if ($phoneNumber && $pdfPath) {
                $wa->sendSuratToWarga(
                    $phoneNumber,
                    $pdfPath,
                    $application->application_number,
                    $application->service->name ?? 'Surat'
                );
            }
        } catch (\Exception $e) {
            Log::error('Kirim WA ke warga gagal: ' . $e->getMessage());
        }

        return redirect()->route('staff.applications')
            ->with('success', '✅ Surat berhasil diterbitkan dan dikirim ke WhatsApp warga.');
    }

    /**
     * Halaman Riwayat Pengajuan (Staff)
     */
    public function riwayat(Request $request)
    {
        $query = Application::with(['user', 'service'])
            ->whereIn('status', ['issued', 'rejected']);

        if ($request->has('service_id') && $request->service_id != '') {
            $query->where('service_id', $request->service_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);
        $services = Service::where('is_active', true)->get();

        return view('staff.riwayat', compact('applications', 'services'));
    }

    /**
     * Tolak Pengajuan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $application = Application::whereIn('status', ['disetujui_rt', 'in_progress'])->findOrFail($id);

        $application->status = 'rejected';
        $application->rejected_reason = $request->reason;
        $application->save();

        return redirect()->route('staff.dashboard')
            ->with('success', '❌ Pengajuan ditolak.');
    }
}