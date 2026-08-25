<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Rt;
// use App\Services\WhatsApp\WhatsAppServiceInterface; // <-- COMMENT: WhatsApp Service
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RtController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $rt = $user->rt;

        // Jika user tidak punya data RT
        if (!$rt) {
            return redirect()->route('home')->with('error', 'Data RT tidak ditemukan. Silakan hubungi admin.');
        }

        // Statistik
        $total = Application::where('rt_id', $rt->id)->count();
        $waiting = Application::where('rt_id', $rt->id)->where('status', 'menunggu_rt')->count();
        $approved = Application::where('rt_id', $rt->id)->where('status', 'disetujui_rt')->count();
        $rejected = Application::where('rt_id', $rt->id)->where('status', 'ditolak_rt')->count();

        // Pengajuan terbaru yang menunggu
        $recentApplications = Application::where('rt_id', $rt->id)
            ->where('status', 'menunggu_rt')
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('rt.dashboard', compact(
            'rt',
            'total',
            'waiting',
            'approved',
            'rejected',
            'recentApplications'
        ));
    }

    public function applications()
    {
        $rt = Auth::user()->rt;
        
        $applications = Application::where('rt_id', $rt->id)
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('rt.applications', compact('applications'));
    }

    public function detail($id)
    {
        $rt = Auth::user()->rt;
        
        $application = Application::where('rt_id', $rt->id)
            ->with(['user', 'service', 'documents'])
            ->findOrFail($id);

        return view('rt.detail', compact('application'));
    }

    public function approve($id)
    // public function approve($id, WhatsAppServiceInterface $whatsapp) // <-- COMMENT: WhatsApp Service
    {
        $rt = Auth::user()->rt;
        
        $application = Application::where('rt_id', $rt->id)
            ->where('status', 'menunggu_rt')
            ->findOrFail($id);

        $application->status = 'disetujui_rt';
        $application->rt_approved_at = now();
        $application->rt_approved_by = Auth::id();
        $application->save();

        // =============================================
        // NOTIFIKASI WHATSAPP (COMMENT SEMENTARA)
        // =============================================
        // $warga = $application->user;
        // if ($warga->nomor_hp) {
        //     $message = "✅ *Pengajuan Surat Disetujui RT*\n\n";
        //     $message .= "Nomor Pengajuan: {$application->application_number}\n";
        //     $message .= "Jenis Surat: {$application->service->name}\n\n";
        //     $message .= "Surat Anda telah disetujui oleh RT dan sedang diproses oleh kelurahan.\n";
        //     $message .= "Status dapat dipantau di SIPMAS.";
        //     $whatsapp->sendText($warga->nomor_hp, $message);
        // }

        return redirect()->route('rt.dashboard')
            ->with('success', '✅ Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    // public function reject(Request $request, $id, WhatsAppServiceInterface $whatsapp) // <-- COMMENT: WhatsApp Service
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $rt = Auth::user()->rt;
        
        $application = Application::where('rt_id', $rt->id)
            ->where('status', 'menunggu_rt')
            ->findOrFail($id);

        $application->status = 'ditolak_rt';
        $application->rt_rejection_reason = $request->reason;
        $application->save();

        // =============================================
        // NOTIFIKASI WHATSAPP (COMMENT SEMENTARA)
        // =============================================
        // $warga = $application->user;
        // if ($warga->nomor_hp) {
        //     $message = "❌ *Pengajuan Surat Ditolak RT*\n\n";
        //     $message .= "Nomor Pengajuan: {$application->application_number}\n";
        //     $message .= "Jenis Surat: {$application->service->name}\n\n";
        //     $message .= "Alasan: {$request->reason}\n\n";
        //     $message .= "Silakan perbaiki dan ajukan ulang.";
        //     $whatsapp->sendText($warga->nomor_hp, $message);
        // }

        return redirect()->route('rt.dashboard')
            ->with('success', '❌ Pengajuan berhasil ditolak.');
    }
}