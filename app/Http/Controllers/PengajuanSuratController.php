<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Application;
use App\Models\Document;
use App\Models\ApplicationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengajuanSuratController extends Controller
{
    // Menampilkan daftar jenis surat (dari database)
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return view('pengajuan-surat', compact('services'));
    }

    // Menampilkan form pengajuan
    public function create(Request $request, $serviceId = null)
    {
        $user = Auth::user();

        // Validasi profil lengkap
        if (!$user->hasCompleteProfile()) {
            $missingFields = $user->getMissingProfileFields();
            $message = '⚠️ Silakan lengkapi data profil Anda terlebih dahulu:<br>';
            $message .= implode(', ', $missingFields);
            
            return redirect()->route('profile.edit')
                ->with('error', $message);
        }
        // Jika ada parameter custom di query string
        if ($request->has('custom')) {
            return view('pengajuan-form', ['isCustom' => true]);
        }

        // Jika serviceId diberikan, ambil data service
        if ($serviceId) {
            $service = Service::findOrFail($serviceId);
            $user = Auth::user();
            $documents = Document::where('user_id', $user->id)->get();
            return view('pengajuan-form', compact('service', 'user', 'documents'));
        }

        // Jika tidak ada parameter, fallback ke daftar surat
        return redirect()->route('pengajuan-surat');
    }

public function store(Request $request)
{
    $user = Auth::user();

    // Validasi: cek apakah warga punya RT
    if (!$user->rt_id) {
        return back()->withErrors(['error' => 'Anda belum memiliki RT. Silakan lengkapi profil Anda.']);
    }

    // Validasi dasar
    $request->validate([
        'service_id' => 'nullable|exists:services,id',
        'custom_service_name' => 'required_if:service_id,null|string|max:100',
        'data' => 'array',
        'notes' => 'nullable|string',
    ]);

    // Cek apakah custom
    $additionalData = $request->data ?? [];
    if (!$request->service_id && $request->custom_service_name) {
        $additionalData['custom_service_name'] = $request->custom_service_name;
    }

    // =============================================
    // GENERATE NOMOR UNIK (AMAN)
    // =============================================
    $lastApplication = Application::orderBy('id', 'desc')->first();
    if ($lastApplication) {
        $lastNumber = (int) substr($lastApplication->application_number, -6);
        $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '000001';
    }

    $applicationNumber = 'REQ-' . date('Y-m') . '-' . $newNumber;

    // Simpan application
    $application = Application::create([
        'user_id' => $user->id,
        'rt_id' => $user->rt_id,
        'service_id' => $request->service_id,
        'application_number' => $applicationNumber,
        'status' => 'menunggu_rt',
        'data' => $additionalData,
        'notes' => $request->notes,
        'submitted_at' => now(),
    ]);

    // =============================================
    // PROSES DOKUMEN
    // =============================================
    // Ambil path KTP & KK dari user
    $ktpPath = $user->ktp_path;
    $kkPath = $user->kk_path;

    // KTP
    if ($ktpPath) {
        // Cek apakah dokumen sudah ada di application_documents
        $existingKTP = ApplicationDocument::where('application_id', $application->id)
            ->where('label', 'KTP')
            ->first();
        
        if (!$existingKTP) {
            // Cari document_id dari path KTP
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

    // Proses dokumen tambahan dari request
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

    return redirect()->route('home')->with('success', 'Pengajuan berhasil dikirim dan menunggu persetujuan RT.');
}
}