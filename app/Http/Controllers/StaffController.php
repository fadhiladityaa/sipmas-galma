<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Letter;
use App\Models\Service;
use App\Services\PdfGenerationService;
use App\Services\SettingService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendWhatsAppJob;

class StaffController extends Controller
{
    protected $pdfService;
    protected $settingService;

    public function __construct(PdfGenerationService $pdfService, SettingService $settingService)
    {
        $this->pdfService = $pdfService;
        $this->settingService = $settingService;
    }

    /**
 * Ubah teks biasa menjadi HTML dengan format yang aman
 */
    private function formatContentToHtml($content)
    {
        // 1. Escape HTML entities agar tidak dieksekusi
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        
        // 2. Ubah baris baru menjadi <br> atau <p>
        $paragraphs = explode("\n\n", $content);
        $formatted = '';
        foreach ($paragraphs as $p) {
            $p = trim($p);
            if (!empty($p)) {
                // Ubah single newline menjadi <br>
                $p = nl2br($p);
                $formatted .= "<p>{$p}</p>";
            }
        }
        
        return $formatted;
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
        $user = $application->user; // <-- TAMBAHKAN INI

        return view('staff.detail', compact('application', 'letter', 'user'));
    }


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


    public function uploadSurat(Request $request, $id)
    {
        $application = Application::where('status', 'in_progress')
            ->where('staff_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'surat_pdf' => 'required|file|mimes:pdf|max:5120', // Max 5MB
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
                'content' => null, // Tidak ada konten manual
                'pdf_path' => $path,
                'issued_at' => null,
            ]
        );

        return redirect()->route('staff.application.detail', $id)
            ->with('success', '✅ Surat berhasil diupload. Klik "Terbitkan" untuk mengirim ke warga.');
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

    public function approve(Request $request, $id)
    {
        $application = Application::whereIn('status', ['in_progress', 'waiting_approval'])->findOrFail($id);

        $request->validate([
            'content' => 'required|string|min:10',
            'letter_number' => 'nullable|string|max:50',
        ]);

        // 1. FORMAT NOMOR SURAT
        $letterNumber = $request->letter_number;
        if ($letterNumber) {
            $fullLetterNumber = '148.3/' . $letterNumber . '/GLM';
        } else {
            $lastNumber = Letter::max('letter_number') ?? 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $fullLetterNumber = '148.3/' . $newNumber . '/GLM';
            $letterNumber = $newNumber;
        }

        // 2. SIMPAN KE DATABASE (LETTER)
        $letter = Letter::updateOrCreate(
            ['application_id' => $application->id],
            [
                'staff_id' => Auth::id(),
                'letter_number' => $letterNumber,
                'content' => $request->content,
                'issued_at' => now(),
            ]
        );

        // 3. UPDATE STATUS APLIKASI
        $application->status = 'issued';
        $application->issued_at = now();
        $application->save();

        // 4. GENERATE PDF
        try {
            $pdfData = $this->preparePdfData($application, $request->content, $fullLetterNumber);
            $pdfFilename = 'surat-' . $application->application_number;
            
            Log::info('Generating PDF...', ['filename' => $pdfFilename]);
            
            $pdfPath = $this->pdfService->generateFromView(
                'staff.preview',
                $pdfData,
                $pdfFilename
            );
            
            Log::info('PDF generated successfully', ['path' => $pdfPath]);

            // =============================================
            // SIMPAN PATH KE DATABASE
            // =============================================
            $letter->pdf_path = $pdfPath;
            $letter->save();
            
            Log::info('PDF path saved to database', ['pdf_path' => $pdfPath]);

        } catch (\Exception $e) {
            Log::error('Generate PDF gagal: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        // 5. KIRIM KE WHATSAPP VIA JOB (QUEUE)
        $phoneNumber = $application->user->nomor_hp;
        
        if ($phoneNumber && $letter->pdf_path) {
            SendWhatsAppJob::dispatch(
                $phoneNumber,
                $letter->pdf_path,
                $application->application_number,
                $application->service->name ?? 'Surat'
            );
        } else {
            Log::warning('WhatsApp tidak dikirim', [
                'phone' => $phoneNumber,
                'pdf_path' => $letter->pdf_path,
            ]);
        }

    return redirect()->route('staff.applications')
        ->with('success', '✅ Surat berhasil diterbitkan.');
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