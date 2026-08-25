<?php

namespace App\Jobs;

use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendWhatsAppJob implements ShouldQueue
{
    use Queueable;

    protected $phoneNumber;
    protected $pdfPath;
    protected $applicationNumber;
    protected $serviceName;

    public function __construct($phoneNumber, $pdfPath, $applicationNumber, $serviceName)
    {
        $this->phoneNumber = $phoneNumber;
        $this->pdfPath = $pdfPath;
        $this->applicationNumber = $applicationNumber;
        $this->serviceName = $serviceName;
    }

    public function handle(WhatsAppService $wa)
    {
        // Cek path file
        $fullPath = storage_path('app/public/' . $this->pdfPath);
        
        if (!file_exists($fullPath)) {
            Log::error('PDF not found in job', ['path' => $fullPath]);
            return;
        }

        $wa->sendSuratToWarga(
            $this->phoneNumber,
            $fullPath,
            $this->applicationNumber,
            $this->serviceName
        );
    }
}