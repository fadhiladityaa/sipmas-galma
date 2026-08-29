<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Application;
use App\Models\Document;
use App\Models\ApplicationDocument;
use App\Models\User; // <-- TAMBAHKAN IMPORT INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class PengajuanSuratController extends Controller
{
        
    // Menampilkan daftar jenis surat
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return view('pengajuan-surat', compact('services'));
    }

    // Menampilkan form pengajuan
    public function create(Request $request, $serviceId = null)
    {
        $user = Auth::user();

        if (!$user->hasCompleteProfile()) {
            $missingFields = $user->getMissingProfileFields();
            $message = '⚠️ Silakan lengkapi data profil Anda terlebih dahulu:<br>';
            $message .= implode(', ', $missingFields);
            
            return redirect()->route('profile.edit')
                ->with('error', $message);
        }

        if ($request->has('custom')) {
            return view('pengajuan-form', ['isCustom' => true]);
        }

        if ($serviceId) {
            $service = Service::findOrFail($serviceId);
            $user = Auth::user();
            $documents = Document::where('user_id', $user->id)->get();
            return view('pengajuan-form', compact('service', 'user', 'documents'));
        }

        return redirect()->route('pengajuan-surat');
    }

     public function home()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi
        if (!$user->rt_id) {
            return back()->withErrors(['error' => 'Anda belum memiliki RT. Silakan lengkapi profil Anda.']);
        }

        $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'custom_service_name' => 'required_if:service_id,null|string|max:100',
            'data' => 'array',
            'notes' => 'nullable|string',
        ]);

        $additionalData = $request->data ?? [];
        if (!$request->service_id && $request->custom_service_name) {
            $additionalData['custom_service_name'] = $request->custom_service_name;
        }

        // GENERATE NOMOR UNIK
        $lastNumber = Application::where('application_number', 'LIKE', 'REQ-2026-08-%')
            ->max('application_number');

        if ($lastNumber) {
            $lastSeq = (int) substr($lastNumber, -6);
            $newNumber = str_pad($lastSeq + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        $applicationNumber = 'REQ-' . date('Y-m') . '-' . $newNumber;

        // =============================================
        // 1. SIMPAN PENGAJUAN
        // =============================================
        $application = Application::create([
            'user_id' => $user->id,
            'rt_id' => $user->rt_id,
            'rw_id' => $user->rw_id,
            'service_id' => $request->service_id,
            'application_number' => $applicationNumber,
            'status' => 'menunggu_rt',
            'data' => $additionalData,
            'notes' => $request->notes,
            'submitted_at' => now(),
        ]);

        // =============================================
        // 2. PROSES DOKUMEN
        // =============================================
        $ktpPath = $user->ktp_path;
        $kkPath = $user->kk_path;

        // KTP
        if ($ktpPath) {
            $existingKTP = ApplicationDocument::where('application_id', $application->id)
                ->where('label', 'KTP')
                ->first();
            
            if (!$existingKTP) {
                $document = Document::where('user_id', $user->id)
                    ->where('file_path', $ktpPath)
                    ->first();
                
                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_id' => $document->id ?? null,
                    'file_path' => $ktpPath,
                    'is_reused' => true,
                    'label' => 'KTP',
                ]);
            }
        }

        // KK
        if ($kkPath) {
            $existingKK = ApplicationDocument::where('application_id', $application->id)
                ->where('label', 'KK')
                ->first();
            
            if (!$existingKK) {
                $document = Document::where('user_id', $user->id)
                    ->where('file_path', $kkPath)
                    ->first();
                
                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_id' => $document->id ?? null,
                    'file_path' => $kkPath,
                    'is_reused' => true,
                    'label' => 'KK',
                ]);
            }
        }

        // Dokumen tambahan
        if ($request->has('documents')) {
            foreach ($request->documents as $key => $value) {
                if ($request->hasFile("documents.$key")) {
                    $file = $request->file("documents.$key");
                    $path = $file->store('documents/'.$user->id, 'public');
                    $document = Document::create([
                        'user_id' => $user->id,
                        'name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'type' => $key,
                    ]);
                    ApplicationDocument::create([
                        'application_id' => $application->id,
                        'document_id' => $document->id,
                        'is_reused' => false,
                        'label' => $key,
                    ]);
                } else {
                    $docId = $value;
                    $document = Document::find($docId);
                    if ($document) {
                        ApplicationDocument::create([
                            'application_id' => $application->id,
                            'document_id' => $document->id,
                            'is_reused' => true,
                            'label' => $document->type,
                        ]);
                    }
                }
            }
        }

        $serviceName = $request->service_id 
            ? Service::find($request->service_id)->name 
            : ($request->custom_service_name ?? 'Surat');

        // =============================================
        // 4. KIRIM NOTIFIKASI KE RT
        // =============================================
        try {
            $wa = app(WhatsAppService::class);
            
            // Ambil user yang memiliki role RT berdasarkan rt_id
            $rtUser = User::where('rt_id', $user->rt_id)
                ->where('role', 'rt')
                ->first();
            
            if ($rtUser && $rtUser->nomor_hp) {
                $wa->notifyRt(
                    $rtUser->nomor_hp,  // <-- Ambil dari users.nomor_hp
                    $user->name,
                    $applicationNumber,
                    $serviceName
                );
            } else {
                Log::warning('RT tidak ditemukan atau tidak punya nomor HP', [
                    'rt_id' => $user->rt_id,
                    'user_id' => $user->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Kirim WA ke RT gagal: ' . $e->getMessage());
        }

        try {
            $wa = app(WhatsAppService::class);
            
            // Ambil user yang memiliki role RW berdasarkan rw_id
            $rwUser = User::where('rw_id', $user->rw_id)
                ->where('role', 'rw')
                ->first();
            
            if ($rwUser && $rwUser->nomor_hp) {
                $wa->notifyRw(
                    $rwUser->nomor_hp,
                    $user->name,
                    $applicationNumber,
                    $serviceName
                );
            } else {
                Log::warning('RW tidak ditemukan atau tidak punya nomor HP', [
                    'rw_id' => $user->rw_id,
                    'user_id' => $user->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Kirim WA ke RW gagal: ' . $e->getMessage());
        }

        return redirect()->route('warga.home')->with('success', 'Pengajuan berhasil dikirim dan menunggu persetujuan RT/RW.');
    }
}