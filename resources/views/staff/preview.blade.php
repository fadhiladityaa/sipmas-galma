<x-app-layout>
    <div class="py-8 no-print">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gama-text">Preview Surat</h2>
                <div class="flex gap-3">
                    <button onclick="window.print()"
                        class="px-4 py-2 bg-gama-primary text-white rounded-lg text-sm hover:bg-[#1f3320] transition">
                        🖨️ Print / Cetak
                    </button>
                    <button onclick="downloadPdf()"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition">
                        📄 Download PDF
                    </button>

                    <a href="{{ route('staff.application.detail', $application->id) }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">
                        Kembali
                    </a>

                </div>
            </div>
            @if ($is_preview ?? false)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4 text-yellow-700 no-print">
                    ⚠️ <strong>Preview Sementara:</strong> Konten belum disimpan.
                    Klik "Terbitkan Surat" untuk menyimpan.
                </div>
            @endif
            @if (isset($application) && $application->status == 'issued' && isset($letter) && $letter->hasPdf())
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 text-green-700 no-print">
                    ✅ <strong>Surat sudah diterbitkan!</strong>
                    <a href="{{ $letter->getPdfUrl() }}" target="_blank"
                        class="ml-2 text-gama-accent hover:text-gama-primary underline font-medium">
                        📄 Download PDF
                    </a>
                </div>
            @endif
        </div>
    </div>


    <!-- KONTEN SURAT -->
    <div id="surat-container"
        style="font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; padding: 40px 50px 40px 50px; background: white; max-width: 900px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow-y: auto; height: auto; max-height: none;">

        @include('letters.templates.' . ($template_name ?? 'format-1'))

    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            nav,
            header,
            footer,
            .sticky,
            .fixed {
                display: none !important;
            }

            body,
            html {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                min-height: auto !important;
            }

            body * {
                visibility: hidden !important;
            }

            #surat-container,
            #surat-container * {
                visibility: visible !important;
            }

            #surat-container {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                border: none !important;
                border-radius: 0 !important;
                padding: .5cm 1cm 1cm 1cm !important;
                margin: 0 !important;
                background: white !important;
                box-shadow: none !important;
                max-width: 100% !important;
                max-height: none !important;
                min-height: 100% !important;
                height: auto !important;
                overflow: visible !important;
            }

            #surat-container table {
                page-break-inside: avoid;
            }

            #surat-container img {
                max-width: 75px !important;
            }
        }
    </style>

    @if (isset($auto_print) && $auto_print)
        <script>
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            }
        </script>
    @endif

    <!-- ============================================= -->
    <!-- FORM UNTUK DOWNLOAD PDF (HIDDEN)              -->
    <!-- ============================================= -->
    <form id="pdfForm" action="{{ route('staff.application.preview', $application->id) }}" method="get"
        target="_blank">
        <input type="hidden" name="content" id="pdf_content" value="{{ $content ?? '' }}">
        <input type="hidden" name="letter_number" id="pdf_letter_number" value="{{ $letter_number ?? '' }}">
        <input type="hidden" name="download_pdf" value="1">
    </form>

    <!-- ============================================= -->
    <!-- JAVASCRIPT UNTUK DOWNLOAD PDF                 -->
    <!-- ============================================= -->
    <script>
        function downloadPdf() {
            // Ambil content dari container surat
            var content = document.querySelector('#surat-container .content')?.innerHTML || '';
            var letterNumber = '{{ $letter_number ?? '' }}';

            document.getElementById('pdf_content').value = content;
            document.getElementById('pdf_letter_number').value = letterNumber;
            document.getElementById('pdfForm').submit();
        }
    </script>
</x-app-layout>
