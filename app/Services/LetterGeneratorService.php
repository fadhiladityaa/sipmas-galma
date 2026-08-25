<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Letter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterGeneratorService
{
    public function generateLetter(Application $application, string $content)
    {
        // 1. Siapkan data untuk template
        $data = $this->prepareData($application, $content);

        // 2. Generate HTML dari Blade template
        $html = View::make('letters.templates.' . $this->getTemplateName($application), $data)->render();

        // 3. Generate PDF
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'portrait');

        // 4. Simpan PDF
        $path = 'letters/' . $application->application_number . '.pdf';
        $fullPath = Storage::disk('public')->put($path, $pdf->output());

        // 5. Simpan ke database
        $letter = Letter::create([
            'application_id' => $application->id,
            'staff_id' => auth()->id(),
            'content' => $content,
            'pdf_path' => $path,
            'issued_at' => now(),
        ]);

        return $letter;
    }

    private function prepareData($application, $content)
    {
        return [
            'application' => $application,
            'user' => $application->user,
            'content' => $content,
            'tanggal' => now()->format('d F Y'),
            'pejabat' => config('letter.pejabat.lurah'),
        ];
    }

    private function getTemplateName($application)
    {
        // Tentukan template berdasarkan service_id atau format
        $serviceId = $application->service_id ?? 0;
        
        $templates = [
            1 => 'format-1',
            2 => 'format-1',
            3 => 'format-2',
            4 => 'format-2',
            5 => 'format-3',
            6 => 'format-4',
            7 => 'format-2',
            8 => 'format-1',
            9 => 'format-1',
            10 => 'format-3',
        ];

        return $templates[$serviceId] ?? 'format-1';
    }
}