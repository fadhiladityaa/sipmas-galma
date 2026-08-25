<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
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
            margin: 10px 0 15px 0;
        }

        .signature {
            text-align: left;
            font-size: 11pt;
            margin-top: 35px;
            margin-left: 25rem;
        }

        .barcode-img {
            width: 100px;
            height: auto;
            display: inline-block;
            margin-right: 100px;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }

        .label {
            width: 45px;
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
            margin-bottom: 15px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0.5cm 1cm 1cm 1cm;
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

    <!-- KOP SURAT (HARDCODE) -->
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
    <div style="line-height: 10px">
        <div class="title">
            {{ strtoupper($application->service->name ?? 'SURAT KETERANGAN') }}
        </div>

        <!-- SURAT -->
        <p style="margin-bottom: 25px; text-align: center;">
            <strong>Nomor :</strong> {{ $letter_number ?? '148.3/ /GLM' }}
        </p>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p style="margin: 0 0 5px 0;">Yang bertanda tangan di bawah ini :</p>
        <table style="margin-left: 20px;">
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td><strong>{{ $pejabat['nama'] ?? 'MUHAMMAD ZULKIFLI FARID, SE' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="separator">:</td>
                <td>Lurah Galung Maloang</td>
            </tr>
        </table>
        <p style="margin: 8px 0 0 0">Dengan ini memberikan keterangan bahwa :</p>

        <table style="margin-left: 20px;">
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td><strong>{{ $user->name }}</strong></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="separator">:</td>
                <td>{{ $user->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat/Tgl.Lahir</td>
                <td class="separator">:</td>
                <td>{{ $user->tempat_lahir ?? '-' }},
                    {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="separator">:</td>
                <td>{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label">Agama</td>
                <td class="separator">:</td>
                <td>{{ $user->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="separator">:</td>
                <td>{{ $user->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td>{{ $user->alamat ?? '-' }}</td>
            </tr>
        </table>

        <br>
        <!-- Konten dinamis dari staff -->
        @if (!empty($content))
            <div style="margin-top: 10px; white-space: pre-wrap;">
                {!! $content !!}
            </div>
        @else
            <p style="color: #999; font-style: italic; text-align: center; margin-top: 15px;">
                ⚠️ Belum ada konten surat.
            </p>
        @endif
    </div>

    <!-- TANDA TANGAN & BARCODE -->
    @php
        $settingService = app(\App\Services\SettingService::class);
        $lurahData = $settingService->getLurahData();
        $barcodeImage = $settingService->getBarcodeImage();
    @endphp

    <div class="signature">
        <p>Parepare, {{ $tanggal }}</p>
        <p>Lurah</p>
        <br>

        @if ($barcodeImage)
            <img src="{{ $barcodeImage }}" alt="Barcode Lurah" class="barcode-img">
        @else
            <div
                style="padding: 8px 15px; background: #f5f5f5; border: 1px dashed #ccc; border-radius: 4px; display: inline-block;">
                <span style="font-size: 9pt; color: #999;">⚠️ Barcode Lurah Belum Diupload</span>
            </div>
        @endif

        <p>{{ $lurahData['nama'] }}</p>
        <p>Pangkat : {{ $lurahData['pangkat'] }}</p>
        <p>Nip. {{ $lurahData['nip'] }}</p>
    </div>

</body>

</html>
