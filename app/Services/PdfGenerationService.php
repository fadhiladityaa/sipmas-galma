<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfGenerationService
{
    /**
     * Generate PDF dari view Blade menggunakan Browsershot
     * 
     * @param string $viewPath Path view (contoh: 'staff.preview')
     * @param array $data Data untuk view
     * @param string $filename Nama file tanpa ekstensi
     * @param string $disk Storage disk (default: 'public')
     * @return string Path file PDF yang tersimpan
     */
    public function generateFromView(string $viewPath, array $data, string $filename, string $disk = 'public'): string
    {
        // 1. Render view ke HTML
        $html = view($viewPath, $data)->render();

        // 2. Generate PDF dengan Browsershot
        $pdfContent = $this->generatePdfFromHtml($html);

        // 3. Simpan file
        $path = "surat/{$filename}.pdf";
        Storage::disk($disk)->put($path, $pdfContent);

        return $path;
    }

    /**
     * Generate PDF dari HTML string
     */
    public function generatePdfFromHtml(string $html): string
    {
        $browsershot = Browsershot::html($html)
            ->format('A4')
            ->margins(10, 10, 10, 10) // top, right, bottom, left (mm)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->setDelay(1000) // Tunggu 1 detik agar render selesai
            ->landscape(false) // Portrait

            // Opsi tambahan untuk kualitas lebih baik
            ->setOption('printBackground', true)
            ->setOption('preferCSSPageSize', true);

        // Set path Node.js jika dikonfigurasi
        if ($nodePath = config('browsershot.node_path')) {
            $browsershot->setNodePath($nodePath);
        }

        if ($npmPath = config('browsershot.npm_path')) {
            $browsershot->setNpmPath($npmPath);
        }

        return $browsershot->pdf();
    }

    /**
     * Generate PDF dari URL (alternatif)
     */
    public function generateFromUrl(string $url, string $filename, string $disk = 'public'): string
    {
        $browsershot = Browsershot::url($url)
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->setDelay(1000)
            ->landscape(false);

        if ($nodePath = config('browsershot.node_path')) {
            $browsershot->setNodePath($nodePath);
        }

        if ($npmPath = config('browsershot.npm_path')) {
            $browsershot->setNpmPath($npmPath);
        }

        $pdfContent = $browsershot->pdf();

        $path = "surat/{$filename}.pdf";
        Storage::disk($disk)->put($path, $pdfContent);

        return $path;
    }

    /**
     * Generate PDF dan return response untuk download
     */
    public function downloadPdf(string $viewPath, array $data, string $filename): \Illuminate\Http\Response
    {
        $html = view($viewPath, $data)->render();
        $pdfContent = $this->generatePdfFromHtml($html);

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.pdf"');
    }

    /**
     * Generate PDF dan return response untuk preview inline
     */
    public function inlinePdf(string $viewPath, array $data, string $filename): \Illuminate\Http\Response
    {
        $html = view($viewPath, $data)->render();
        $pdfContent = $this->generatePdfFromHtml($html);

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '.pdf"');
    }
}