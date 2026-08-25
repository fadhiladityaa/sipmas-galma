<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $sender;

    public function __construct()
    {
        $this->apiKey = env('FONNTE_API_KEY');
        $this->sender = env('FONNTE_SENDER');
    }

    /**
     * Format nomor HP ke format Fonnte (62xxxx)
     */
    private function formatPhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika diawali 8, tambahkan 62
        if (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Kirim pesan teks
     */
    public function sendText($phoneNumber, $message)
    {
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

          $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            ])->timeout(30) // <-- TAMBAHKAN INI (30 detik)
            ->post('https://api.fonnte.com/send', [
                'target' => $phoneNumber,
                'message' => $message,
            ]);


        if ($response->successful()) {
            Log::info('WhatsApp sent', ['phone' => $phoneNumber]);
            return true;
        }

        Log::error('WhatsApp failed', [
            'phone' => $phoneNumber,
            'response' => $response->body(),
        ]);

        return false;
    }

    /**
     * Kirim dokumen (PDF)
     */
    public function sendDocument($phoneNumber, $filePath, $filename, $caption = '')
    {
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        if (!file_exists($filePath)) {
            Log::error('File not found: ' . $filePath);
            return false;
        }

       $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->timeout(60) // <-- TAMBAHKAN INI (60 detik untuk file)
        ->attach('file', file_get_contents($filePath), $filename)
        ->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $caption,
        ]);


        if ($response->successful()) {
            Log::info('Document sent', ['phone' => $phoneNumber]);
            return true;
        }

        Log::error('Document send failed', [
            'phone' => $phoneNumber,
            'response' => $response->body(),
        ]);

        return false;
    }

    /**
     * Kirim surat ke warga
     */
    public function sendSuratToWarga($phoneNumber, $pdfPath, $applicationNumber, $serviceName)
    {
        // Buat URL publik ke PDF
        $pdfUrl = asset('storage/' . $pdfPath);

        $caption = "✅ *Surat Anda Telah Diterbitkan!*\n\n";
        $caption .= "Nomor: {$applicationNumber}\n";
        $caption .= "Jenis: {$serviceName}\n\n";
        $caption .= "📄 Download PDF: {$pdfUrl}\n\n";
        $caption .= "Terima kasih telah menggunakan SIPMAS Galung Maloang.";

        return $this->sendText($phoneNumber, $caption);
    }

    // ... method lainnya (notifyRT, notifyStaff) ...
}