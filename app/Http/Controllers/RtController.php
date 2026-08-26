<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Rt;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RtController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $rt = $user->rt;

        if (!$rt) {
            return redirect()->route('home')->with('error', 'Data RT tidak ditemukan. Silakan hubungi admin.');
        }

        $total = Application::where('rt_id', $rt->id)->count();
        $waiting = Application::where('rt_id', $rt->id)->where('status', 'menunggu_rt')->count();
        $approved = Application::where('rt_id', $rt->id)->where('status', 'disetujui_rt')->count();
        $rejected = Application::where('rt_id', $rt->id)->where('status', 'ditolak_rt')->count();

        $recentApplications = Application::where('rt_id', $rt->id)
            ->where('status', 'menunggu_rt')
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('rt.dashboard', compact(
            'rt', 'total', 'waiting', 'approved', 'rejected', 'recentApplications'
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
        // KIRIM NOTIFIKASI KE STAFF
        // =============================================
        try {
            $wa = app(WhatsAppService::class);
            
            // Ambil semua user dengan role staff
            $staffUsers = User::where('role', 'staff')->get();
            
            foreach ($staffUsers as $staff) {
                if ($staff->nomor_hp) {
                    $wa->notifyStaff(
                        $staff->nomor_hp,
                        $application->user->name,
                        $application->application_number,
                        $application->service->name ?? 'Surat'
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error('Kirim WA ke Staff gagal: ' . $e->getMessage());
        }

        return redirect()->route('rt.dashboard')
            ->with('success', '✅ Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, $id)
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

        return redirect()->route('rt.dashboard')
            ->with('success', '❌ Pengajuan berhasil ditolak.');
    }
}