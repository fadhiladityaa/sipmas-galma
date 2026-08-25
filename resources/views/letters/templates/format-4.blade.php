<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 2cm 2cm 2cm 2.5cm;
            background: white;
        }

        .content {
            text-align: justify;
            font-size: 11pt;
        }

        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .signature {
            text-align: left;
            font-size: 11pt;
            margin-top: 35px;
            margin-left: 25rem;
            display: flex;
            flex-direction: column;
            gap: 1;
        }

        .barcode-img {
            width: 100px;
            height: auto;
            display: inline-block;
            margin-right: 100px;
            margin-bottom: 10px;
        }

        .poin-ketentuan {
            margin-left: 20px;
            margin-top: 5px;
        }

        .poin-ketentuan-item {
            margin-left: 20px;
            margin-bottom: 3px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }

        .label {
            width: 40px;
        }

        .separator {
            width: 10px;
            text-align: center;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin-bottom: 8px;
        }

        .kop-logo {
            width: 100px;
            vertical-align: middle;
            padding-right: 15px;
        }

        .kop-logo img {
            width: 85px;
            height: auto;
            display: block;
        }

        .kop-text {
            vertical-align: middle;
            text-align: center;
        }

        .kop-text .pemkot {
            font-size: 14pt;
            letter-spacing: 1px;
        }

        .kop-text .kecamatan {
            font-size: 14pt;
            letter-spacing: 1px;
        }

        .kop-text .kelurahan {
            font-weight: bold;
            font-size: 15pt;
        }

        .kop-text .alamat {
            font-size: 9pt;
        }

        .kop-text .kota {
            font-size: 14pt;
        }

        .kop-kode {
            vertical-align: bottom;
            font-size: 10pt;
        }

        .kop-garis {
            border-bottom: 3px double #000;
            margin-bottom: 10px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0cm 1cm 1cm 1cm;
            }

            .barcode-img {
                max-width: 75px !important;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ asset('img/logo-parepare.webp') }}" alt="Logo Parepare">
            </td>
            <td class="kop-text">
                <div class="pemkot">PEMERINTAH KOTA PAREPARE</div>
                <div class="kecamatan">KECAMATAN BACUKIKI</div>
                <div class="kelurahan">KELURAHAN GALUNG MALOANG</div>
                <div class="alamat">Jalan Cendrawasih Kompleks Perumahan PNS Telp. (0421) .......................</div>
                <div class="kota">PAREPARE &nbsp;&nbsp;</div>
            </td>
            <td class="kop-kode">Kode Pos 91125</td>
        </tr>
    </table>
    <div class="kop-garis"></div>

    <!-- JUDUL SURAT -->
    <div style="line-height: 20px;" class="topper-container">
        <div class="title" style="font-size: 12pt">
            {{ strtoupper($application->service->name ?? 'SURAT REKOMENDASI BBM JENIS TERTENTU') }}
        </div>

        <!-- NOMOR SURAT -->
        <p style="text-align: center; margin-bottom: 20px;">
            <strong>Nomor : {{ $letter_number ?? '148.3/ /GLM' }}</strong>
        </p>
    </div>

    <!-- ISI SURAT -->
    <div style="font-size: 10pt" class="content">

        <!-- DASAR HUKUM -->
        <p><strong>Dasar Hukum :</strong></p>
        <div class="dasar-hukum">
            <p class="dasar-hukum-item">1. Undang-undang Nomor 22 tahun 2001 tentang Minyak Gas Bumi</p>
            <p class="dasar-hukum-item">2. Undang-undang Nomor 32 Tahun 2004 tentang Pemerintahan Daerah</p>
            <p class="dasar-hukum-item">3. Perpres Nomor 15 Tahun 2012 tentang Harga Jual Eceran dan Konsumen - pengguna
                Jenis Bahan Bakar Minyak Tertentu</p>
        </div>

        <!-- REKOMENDASI -->
        <p style="margin-top:8px;">Dengan ini Memberikan Rekomendasi kepada :</p>
        <table style="margin-left: 20px; border: none; line-height: 13px;">
            <tr>
                <td style="width: 80px; border: none; width: 150px;">Nama</td>
                <td style="width: 10px; border: none;">:</td>
                <td style="border: none;">{{ $user->name }}</td>
            </tr>
            <tr>
                <td style="border: none;">NIK</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ $user->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Alamat Usaha</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ $user->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Konsumen Pengguna</td>
                <td style="border: none;">:</td>
                <td style="border: none;">Usaha Mikro/Pertanian/Perikanan/Pelayanan Umum</td>
            </tr>
            <tr>
                <td style="border: none;">Jenis Usaha/Kegiatan</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ $application->data['jenis_usaha'] ?? 'Pertanian' }}</td>
            </tr>
        </table>
        <!-- TABEL DATA TEKNIS -->
        <p style="margin-top:8px">Berdasarkan hasil verifikasi, kebutuhan BBM digunakan untuk sarana sebagai berikut :
        </p>

        <table style="width: 100%; margin-top: 5px; border: 1px solid black; text-align: center;">
            <thead style="font-size: 8pt; font-weight: 100">
                <tr style="border: 1px solid black;">
                    <th style="width: 5%; border: 1px solid black;">NO</th>
                    <th style="width: 20%; border: 1px solid black;">Jenis Alat</th>
                    <th style="width: 10%; border: 1px solid black;">Jumlah Alat</th>
                    <th style="width: 20%; border: 1px solid black;">Fungsi Alat</th>
                    <th style="width: 15%; border: 1px solid black;">BBM Jenis Tertentu</th>
                    <th style="width: 15%; border: 1px solid black;">Jam Operasi/Hari</th>
                    <th style="width: 15%; border: 1px solid black;">Konsumsi BBM (Liter/Hari)</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border: 1px solid black; height: 30px;">
                    <td style="border: 1px solid black;">1</td>
                    <td style="border: 1px solid black;">{{ $application->data['jenis_alat'] ?? 'Mesin Pompa Air' }}
                    </td>
                    <td style="border: 1px solid black;">{{ $application->data['jumlah_alat'] ?? '1' }}</td>
                    <td style="border: 1px solid black;">{{ $application->data['fungsi_alat'] ?? 'Memompa air' }}</td>
                    <td style="border: 1px solid black;">{{ $application->data['bbm_jenis'] ?? 'Pertalite' }}</td>
                    <td style="border: 1px solid black;">{{ $application->data['jam_operasi'] ?? '24' }} Jam</td>
                    <td style="border: 1px solid black;">{{ $application->data['konsumsi_bbm'] ?? '30' }} Liter/Hari
                    </td>
                </tr>
                <tr style="height: 1px;">
                    <td colspan="6" style="text-align: right;">Jumlah</td>
                    <td>{{ $application->data['konsumsi_bbm'] ?? '30' }} Liter/Hari</td>
                </tr>
            </tbody>
        </table>
        <!-- ALOKASI VOLUME -->
        <p style="margin-top: 8px">
            Di berikan alokasi Volume Bensin Pertalite / Minyak Solar (Gas Oli)
        </p>
        <div style="margin-left: 20px;">
            <p>a. Sejumlah : {{ $application->data['konsumsi_bbm'] ?? '30' }} Liter/Hari</p>
            <p>b. Tempat Pengambilan : Lembaga Penyalur (SPBU/APM/SPDN/SPBN)</p>
            <p>c. Nomor Lembaga Penyalur : {{ $application->data['nomor_penyalur'] ?? '7491172' }}</p>
            <p>d. Lokasi : {{ $application->data['lokasi_penyalur'] ?? 'Jl. Jend. Muh. Yusuf' }}</p>
        </div>

        <!-- MASA BERLAKU -->
        <p style="margin: 8px 0 8px 0;">
            Masa berlaku surat rekomendasi sampai 1 Bulan
        </p>

        <!-- SANKSI -->
        <p>
            Apabila Pengguna surat rekomendasi ini tidak sebagaimana mestinya, maka akan di cabut dan ditindak lanjuti
            dengan proses hukum sesuai dengan ketentuan dan peraturan perundang-undangan.
        </p>

        <!-- Konten dinamis dari staff -->
        @if (!empty($content))
            <div style="margin-top: 10px;">
                {!! nl2br(e($content)) !!}
            </div>
        @endif

    </div>

    <!-- TANDA TANGAN & BARCODE -->
    @php
        $settingService = app(\App\Services\SettingService::class);
        $lurahData = $settingService->getLurahData();
        $barcodeImage = $settingService->getBarcodeImage();
    @endphp

    <div style="font-size: 10pt;" class="signature">
        <p>Parepare, {{ $tanggal }}</p>
        <p style="margin-bottom: 8px;">Lurah</p>
        @if ($barcodeImage)
            <img src="{{ $barcodeImage }}" alt="Barcode Lurah" class="barcode-img">
        @else
            <div
                style="padding: 8px 15px; background: #f5f5f5; border: 1px dashed #ccc; border-radius: 4px; display: inline-block;">
                <span style="font-size: 9pt; color: #999;">⚠️ Barcode Lurah Belum Diupload</span>
            </div>
        @endif

        <p style="font-size: 10pt;">{{ $lurahData['nama'] }}</p>
        <p style="font-size: 10pt;">Pangkat : {{ $lurahData['pangkat'] }}</p>
        <p style="font-size: 10pt;">Nip. {{ $lurahData['nip'] }}</p>
    </div>

</body>

</html>
