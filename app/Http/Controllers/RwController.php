<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RwController extends Controller
{
    /**
     * Dashboard RW
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Akun RW terhubung ke tabel rws melalui rws.user_id
        $rw = $user->rwProfile;

        if (!$rw) {
            return redirect()->route('home')
                ->with('error', 'Data RW tidak ditemukan.');
        }

        $total = Application::where('rw_id', $rw->id)->count();

        $waiting = Application::where('rw_id', $rw->id)
            ->where('status', 'menunggu_rt')
            ->count();

        $approved = Application::where('rw_id', $rw->id)
            ->where('status', 'disetujui_rt')
            ->count();

        $rejected = Application::where('rw_id', $rw->id)
            ->where('status', 'ditolak_rt')
            ->count();

        $recentApplications = Application::where('rw_id', $rw->id)
            ->where('status', 'menunggu_rt')
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('rw.dashboard', compact(
            'rw',
            'total',
            'waiting',
            'approved',
            'rejected',
            'recentApplications'
        ));
    }

    /**
     * Daftar pengajuan
     */
    public function applications()
    {
        $rw = Auth::user()->rwProfile;

        if (!$rw) {
            return redirect()->route('home')
                ->with('error', 'Data RW tidak ditemukan.');
        }

        $applications = Application::where('rw_id', $rw->id)
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('rw.applications', compact('applications'));
    }

    /**
     * Detail pengajuan
     */
    public function detail($id)
    {
        $rw = Auth::user()->rwProfile;

        if (!$rw) {
            return redirect()->route('home')
                ->with('error', 'Data RW tidak ditemukan.');
        }

        $application = Application::where('rw_id', $rw->id)
            ->with(['user', 'service', 'documents'])
            ->findOrFail($id);

        return view('rw.detail', compact('application'));
    }

    /**
     * Approve pengajuan
     */
    public function approve($id)
    {
        $rw = Auth::user()->rwProfile;

        if (!$rw) {
            return redirect()->route('home')
                ->with('error', 'Data RW tidak ditemukan.');
        }

        $application = Application::where('rw_id', $rw->id)
            ->where('status', 'menunggu_rt')
            ->findOrFail($id);

        $application->status = 'disetujui_rt';
        $application->rt_approved_at = now();
        $application->rt_approved_by = Auth::id();
        $application->save();

        try {
            $wa = app(WhatsAppService::class);

            // ==========================================
            // NOTIFIKASI STAFF
            // ==========================================

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

            // ==========================================
            // NOTIFIKASI RT
            // ==========================================

            $rtUser = User::where('rt_id', $application->rt_id)
                ->where('role', 'rt')
                ->first();

            if ($rtUser && $rtUser->nomor_hp) {
                $wa->notifyRt(
                    $rtUser->nomor_hp,
                    $application->user->name,
                    $application->application_number,
                    $application->service->name ?? 'Surat'
                );
            }

        } catch (\Exception $e) {
            Log::error(
                'Kirim WA gagal: ' . $e->getMessage()
            );
        }

        return redirect()
            ->route('rw.dashboard')
            ->with('success', '✅ Pengajuan berhasil disetujui.');
    }

    /**
     * Reject pengajuan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $rw = Auth::user()->rwProfile;

        if (!$rw) {
            return redirect()->route('home')
                ->with('error', 'Data RW tidak ditemukan.');
        }

        $application = Application::where('rw_id', $rw->id)
            ->where('status', 'menunggu_rt')
            ->findOrFail($id);

        $application->status = 'ditolak_rt';
        $application->rt_rejection_reason = $request->reason;
        $application->save();

        return redirect()
            ->route('rw.dashboard')
            ->with('success', '❌ Pengajuan berhasil ditolak.');
    }
}