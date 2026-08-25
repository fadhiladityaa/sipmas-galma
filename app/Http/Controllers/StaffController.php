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
        $application = Application::with(['user', 'service', 'documents'])
            ->whereIn('status', ['disetujui_rt', 'in_progress', 'waiting_approval'])
            ->findOrFail($id);

        $letter = Letter::where('application_id', $application->id)->first();
        $services = Service::where('is_active', true)->get();
        $user = $application->user;

        return view('staff.detail', compact('application', 'services', 'letter', 'user'));
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
            ->with('success', 'Pengajuan mulai diproses.');
    }

    /**
     * Bersihkan HTML yang tidak lengkap/rusak
     */
    private function cleanHtmlContent($content)
    {
        // 1. Hapus tag yang tidak lengkap
        $content = preg_replace('/<[^>]*$/', '', $content);
        $content = preg_replace('/^[^<]*>/', '', $content);
        
        // 2. Tutup tag yang tidak ditutup
        $content = $this->closeUnclosedTags($content);
        
        // 3. Hapus atribut kosong atau rusak
        $content = preg_replace('/\s+style="[^"]*"/', '', $content);
        
        // 4. Hapus komentar HTML yang tidak lengkap
        $content = preg_replace('/<!--.*?-->/', '', $content);
        
        // 5. Hapus whitespace berlebih
        $content = trim($content);
        
        return $content;
    }

    /**
     * Tutup tag HTML yang tidak ditutup
     */
    private function closeUnclosedTags($html)
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        
        // Wrap dengan body untuk menghindari error
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        
        // Simpan HTML yang sudah diperbaiki
        $fixedHtml = $dom->saveHTML();
        
        // Hapus wrapper DOCTYPE dan html/body jika ada
        $fixedHtml = preg_replace('/^<!DOCTYPE.*?>/', '', $fixedHtml);
        $fixedHtml = preg_replace('/^<html>.*?<body>/', '', $fixedHtml);
        $fixedHtml = preg_replace('/<\/body><\/html>$/', '', $fixedHtml);
        
        return trim($fixedHtml);
    }

    /**
     * Approve dan terbitkan surat (dengan generate PDF)
     */
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

    /**
     * Preview surat (HTML atau PDF)
     */
    public function preview(Request $request, $id)
    {
        $application = Application::with(['user', 'service'])->findOrFail($id);
        $letter = Letter::where('application_id', $application->id)->first();

         $content = $request->input('content', $request->query('content', $letter->content ?? ''));
         $letterNumber = $request->input('letter_number', $request->query('letter_number', $letter->letter_number ?? ''));   
        $fullLetterNumber = $letterNumber ? '148.3/' . $letterNumber . '/GLM' : '148.3/ /GLM';

        // Cek apakah request untuk download PDF
        if ($request->has('download_pdf')) {
            return $this->downloadPdf($application, $content, $fullLetterNumber);
        }

        // Cek apakah request untuk preview PDF (inline)
        if ($request->has('preview_pdf')) {
            return $this->previewPdf($application, $content, $fullLetterNumber);
        }

        $serviceId = $application->service_id ?? 0;

       $templateMap = [
            1 => 'format-1',   // Domisili
            2 => 'format-ortu', // Penghasilan Orang Tua
            3 => 'format-2',   // Tidak Mampu
            4 => 'format-2',   // Usaha
            5 => 'format-3',   // Izin Keramaian
            6 => 'format-4',   // BBM  <-- PASTIKAN ID 6
            7 => 'format-2',   // Belum Menikah
            8 => 'format-1',   // Kematian
            9 => 'format-1',   // Tanah Tidak Sengketa
            10 => 'format-3',  // SKCK
        ];

        $templateName = $templateMap[$serviceId] ?? 'format-1';

        $data = [
            'application' => $application,
            'user' => $application->user,
            'content' => $content,
            'letter_number' => $fullLetterNumber,
            'tanggal' => now()->format('d F Y'),
            'is_preview' => true,
            'template_name' => $templateName,
            'auto_print' => $request->has('print'),
            'letter' => $letter,
            'pejabat' => $this->settingService->getLurahData(),
            'barcode_image' => $this->settingService->getBarcodeImage(),
        ];

        // Tambahkan flag jika PDF sudah di-generate
        if ($request->has('pdf_generated')) {
            $data['pdf_generated'] = true;
        }

        return view('staff.preview', $data);
    }

    /**
     * Download PDF surat yang sudah diterbitkan
     */
    public function downloadPdfSurat($id)
    {
        $letter = Letter::where('application_id', $id)->firstOrFail();

        if (!$letter->pdf_path || !Storage::disk('public')->exists($letter->pdf_path)) {
            // Jika PDF belum ada, generate ulang
            $application = Application::with(['user', 'service'])->findOrFail($id);
            $pdfData = $this->preparePdfData($application, $letter->content, $letter->letter_number);
            $pdfPath = $this->pdfService->generateFromView(
                'staff.preview',
                $pdfData,
                'surat-' . $application->application_number
            );
            $letter->pdf_path = $pdfPath;
            $letter->save();
        }

        return response()->download(storage_path('app/public/' . $letter->pdf_path));
    }

    /**
     * Siapkan data untuk PDF
     */
    private function preparePdfData($application, $content, $letterNumber)
    {
        $cleanContent = strip_tags($content); // Hanya teks biasa
        $cleanContent = nl2br($cleanContent); // Ubah enter jadi <br>
        $serviceId = $application->service_id ?? 0;

        $templateMap = [
            1 => 'format-1', 2 => 'format-ortu', 8 => 'format-1', 9 => 'format-1',
            3 => 'format-2', 4 => 'format-2', 7 => 'format-2',
            5 => 'format-3', 10 => 'format-3',
            6 => 'format-4',
        ];

        $templateName = $templateMap[$serviceId] ?? 'format-1';

        return [
            'application' => $application,
            'user' => $application->user,
            'content' => $cleanContent,
            'letter_number' => $letterNumber,
            'tanggal' => now()->format('d F Y'),
            'is_preview' => false,
            'template_name' => $templateName,
            'auto_print' => false,
            'pejabat' => $this->settingService->getLurahData(),
            'barcode_image' => $this->settingService->getBarcodeImage(),
            'is_pdf' => true,
        ];
    }

    /**
     * Generate PDF dari preview (untuk download)
     */
    private function downloadPdf($application, $content, $letterNumber)
    {
        $data = $this->preparePdfData($application, $content, $letterNumber);
        $filename = 'surat-' . $application->application_number;

        return $this->pdfService->downloadPdf('staff.preview', $data, $filename);
    }

    /**
     * Generate PDF dari preview (untuk preview inline)
     */
    private function previewPdf($application, $content, $letterNumber)
    {
        $data = $this->preparePdfData($application, $content, $letterNumber);
        $filename = 'surat-' . $application->application_number;

        return $this->pdfService->inlinePdf('staff.preview', $data, $filename);
    }
}