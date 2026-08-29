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
        $rw = $user->rw; // Relasi: User → Rw

        if (!$rw) {
            return redirect()->route('rw.dashboard')
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
            'rw', 'total', 'waiting', 'approved', 'rejected', 'recentApplications'
        ));
    }

    /**
     * Daftar pengajuan
     */
    public function applications()
    {
        $rw = Auth::user()->rw;

        if (!$rw) {
            return redirect()->route('rw.dashboard')
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
        $rw = Auth::user()->rw;

        if (!$rw) {
            return redirect()->route('rw.dashboard')
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
        $rw = Auth::user()->rw;

        if (!$rw) {
            return redirect()->route('rw.dashboard')
                ->with('error', 'Data RW tidak ditemukan.');
        }

        $application = Application::where('rw_id', $rw->id)
            ->where('status', 'menunggu_rt')
            ->findOrFail($id);

        $application->status = 'disetujui_rt';
        $application->rt_approved_at = now();
        $application->rt_approved_by = Auth::id();
        $application->save();

        // =============================================
        // KIRIM NOTIFIKASI KE STAFF (WORKLOAD-BASED)
        // =============================================
        try {
            $wa = app(WhatsAppService::class);
            
            // Hitung workload setiap staff
            $staffList = User::where('role', 'staff')
                ->withCount(['applications' => function($q) {
                    $q->where('status', 'in_progress');
                }])
                ->orderBy('applications_count', 'asc')
                ->get();

            // Pilih staff dengan workload paling rendah
            $selectedStaff = $staffList->first();

            if ($selectedStaff && $selectedStaff->nomor_hp) {
                $wa->notifyStaff(
                    $selectedStaff->nomor_hp,
                    $application->user->name,
                    $application->application_number,
                    $application->service->name ?? 'Surat'
                );
                
                Log::info('Staff dipilih berdasarkan workload (RW)', [
                    'staff_id' => $selectedStaff->id,
                    'workload' => $selectedStaff->applications_count
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Kirim WA ke Staff gagal: ' . $e->getMessage());
        }

        return redirect()->route('rw.dashboard')
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

        $rw = Auth::user()->rw;

        if (!$rw) {
            return redirect()->route('rw.dashboard')
                ->with('error', 'Data RW tidak ditemukan.');
        }

        $application = Application::where('rw_id', $rw->id)
            ->where('status', 'menunggu_rt')
            ->findOrFail($id);

        $application->status = 'ditolak_rt';
        $application->rt_rejection_reason = $request->reason;
        $application->save();

        return redirect()->route('rw.dashboard')
            ->with('success', '❌ Pengajuan berhasil ditolak.');
    }
}