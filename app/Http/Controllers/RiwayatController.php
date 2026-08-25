<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    // Halaman daftar riwayat
    public function index()
    {
        $applications = Application::with(['service'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Application::where('user_id', Auth::id())->count(),
            'pending' => Application::where('user_id', Auth::id())
                ->where('status', 'menunggu_rt')->count(),
            'processed' => Application::where('user_id', Auth::id())
                ->whereIn('status', ['disetujui_rt', 'in_progress'])->count(),
            'completed' => Application::where('user_id', Auth::id())
                ->where('status', 'issued')->count(),
            'rejected' => Application::where('user_id', Auth::id())
                ->whereIn('status', ['ditolak_rt', 'rejected'])->count(),
        ];

        return view('riwayat', compact('applications', 'stats'));
    }

        public function download($id)
    {
        $application = Application::with(['letter'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Cek apakah surat sudah diterbitkan
        if ($application->status !== 'issued') {
            abort(404, 'Surat belum diterbitkan.');
        }

        // Cek apakah ada letter dan PDF
        if (!$application->letter || !$application->letter->pdf_path) {
            abort(404, 'File PDF belum tersedia.');
        }

        $pdfPath = storage_path('app/public/' . $application->letter->pdf_path);
        
        if (!file_exists($pdfPath)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        return response()->download($pdfPath);
    }

    // Halaman tracking detail
    public function tracking($id)
    {
        $application = Application::with(['user', 'service', 'documents', 'letter'])
            ->where('user_id', Auth::id()) // Hanya milik user sendiri
            ->findOrFail($id);

        // Buat timeline dari status
        $timeline = $this->buildTimeline($application);

        return view('tracking', compact('application', 'timeline'));
    }

    // Fungsi untuk membuat timeline
    private function buildTimeline($application)
    {
        $timeline = [];

        // 1. Pengajuan dibuat (created_at)
        $timeline[] = [
            'status' => 'Diajukan',
            'description' => 'Pengajuan surat berhasil dikirim',
            'time' => $application->created_at,
            'icon' => '📤',
            'is_completed' => true,
        ];

        // 2. Menunggu RT (jika status setelah submitted)
        if (in_array($application->status, ['menunggu_rt', 'disetujui_rt', 'ditolak_rt'])) {
            $timeline[] = [
                'status' => 'Menunggu Persetujuan RT',
                'description' => 'Pengajuan sedang menunggu persetujuan Ketua RT',
                'time' => $application->submitted_at ?? $application->created_at,
                'icon' => '⏳',
                'is_completed' => $application->status != 'menunggu_rt',
            ];
        }

        // 3. Disetujui RT
        if (in_array($application->status, ['disetujui_rt', 'in_progress', 'issued', 'rejected'])) {
            $timeline[] = [
                'status' => 'Disetujui RT',
                'description' => 'Pengajuan telah disetujui oleh Ketua RT',
                'time' => $application->rt_approved_at ?? $application->updated_at,
                'icon' => '✅',
                'is_completed' => true,
            ];
        }

        // 4. Ditolak RT (jika status ditolak_rt)
        if ($application->status == 'ditolak_rt') {
            $timeline[] = [
                'status' => 'Ditolak RT',
                'description' => 'Pengajuan ditolak oleh Ketua RT: ' . ($application->rt_rejection_reason ?? 'Tidak ada alasan'),
                'time' => $application->updated_at,
                'icon' => '❌',
                'is_completed' => true,
                'is_rejected' => true,
            ];
        }

        // 5. Diproses Staff
        if (in_array($application->status, ['in_progress', 'issued', 'rejected'])) {
            $timeline[] = [
                'status' => 'Diproses Staff',
                'description' => 'Pengajuan sedang diproses oleh staff kelurahan',
                'time' => $application->processed_at ?? $application->updated_at,
                'icon' => '⚙️',
                'is_completed' => $application->status != 'in_progress',
            ];
        }

        // 6. Ditolak Staff
        if ($application->status == 'rejected') {
            $timeline[] = [
                'status' => 'Ditolak Staff',
                'description' => 'Pengajuan ditolak: ' . ($application->rejected_reason ?? 'Tidak ada alasan'),
                'time' => $application->updated_at,
                'icon' => '❌',
                'is_completed' => true,
                'is_rejected' => true,
            ];
        }

        // 7. Surat Diterbitkan
        if ($application->status == 'issued') {
            $timeline[] = [
                'status' => 'Surat Diterbitkan',
                'description' => 'Surat telah selesai dan dapat diunduh',
                'time' => $application->issued_at ?? $application->updated_at,
                'icon' => '📄',
                'is_completed' => true,
                'has_pdf' => $application->letter && $application->letter->pdf_path,
                'pdf_url' => $application->letter ? asset('storage/' . $application->letter->pdf_path) : null,
            ];
        }

        return $timeline;
    }
}