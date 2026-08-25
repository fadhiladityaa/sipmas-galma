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
            margin-bottom: 0;
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
            {{ strtoupper($application->service->name ?? 'SURAT KETERANGAN PENGHASILAN ORANG TUA') }}
        </div>

        <!-- NOMOR SURAT -->
        <p style="margin-bottom: 25px; text-align: center;">
            <strong>Nomor :</strong> {{ $letter_number ?? '148.3/ /GLM' }}
        </p>
    </div>

    <!-- ISI SURAT -->
    <div style="font-size: 11pt;" class="content">

        <!-- Yang bertanda tangan -->
        <p>Yang bertanda tangan di bawah ini :</p>
        <table style="margin-left: 20px;">
            <tr>
                <td style="width: 40px; padding: 2px 0;">Nama</td>
                <td style="width: 10px; padding: 2px 0;">:</td>
                <td style="padding: 2px 0;"><strong>{{ $pejabat['nama'] ?? 'MUHAMMAD ZULKIFLI FARID, SE' }}</strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Jabatan</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">Lurah Galung Maloang</td>
            </tr>
        </table>
        <!-- Data Orang Tua -->
        <p style="margin-top:10px;">Dengan ini memberikan keterangan bahwa :</p>
        <table style="margin-left: 20px;">
            <tr>
                <td style="width: 130px; padding: 2px 0;">Nama</td>
                <td style="width: 10px; padding: 2px 0;">:</td>
                <td style="padding: 2px 0;"><strong>{{ $user->name }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Tempat/Tgl.Lahir</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">{{ $user->tempat_lahir ?? '-' }},
                    {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Jenis Kelamin</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Agama</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">{{ $user->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Pekerjaan</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">{{ $user->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Alamat</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">{{ $user->alamat ?? '-' }}</td>
            </tr>
        </table>

        <!-- Adalah benar orang tua/wali dari -->
        <p style="margin-top: 10px;">
            Adalah benar orang tua/wali dari :
        </p>

        <!-- Data Anak (dari data tambahan pengajuan) -->
        <table style="margin-left: 20px; font-size: 11pt;">
            <tr>
                <td style="width: 130px; padding: 2px 0;">Nama</td>
                <td style="width: 10px; padding: 2px 0;">:</td>
                <td style="padding: 2px 0;"><strong>{{ $application->data['anak_nama'] ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Tempat/Tgl.Lahir</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">
                    @php
                        $tempat = $application->data['anak_tempat_lahir'] ?? '-';
                        $tgl = $application->data['anak_tanggal_lahir'] ?? '';
                        $tglFormatted = $tgl ? \Carbon\Carbon::parse($tgl)->format('d F Y') : '-';
                    @endphp
                    {{ $tempat }}, {{ $tglFormatted }}
                </td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Jenis Kelamin</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">
                    {{ $application->data['anak_jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Pekerjaan</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">{{ $application->data['anak_pekerjaan'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Alamat</td>
                <td style="padding: 2px 0;">:</td>
                <td style="padding: 2px 0;">{{ $application->data['anak_alamat'] ?? ($user->alamat ?? '-') }}</td>
            </tr>
        </table>
        <!-- Narasi penghasilan -->
        <!-- Konten dinamis dari staff -->
        @if (!empty($content))
            <div style="margin-top: 10px;">
                {!! nl2br(e(strip_tags($content))) !!}
            </div>
        @else
            <p style="color: #999; font-style: italic; text-align: center; margin-top: 15px;">
                ⚠️ Belum ada konten surat. Silakan tulis isi surat di halaman proses.
            </p>
        @endif

    </div>

    <br>
    <p style="font-size: 11pt;">
        Demikian Surat Keterangan ini dibuat dan diberikan kepada yang bersangkutan
        untuk dipergunakan sebagaimana mestinya.
    </p>

    <!-- TANDA TANGAN & BARCODE -->
    @php
        $settingService = app(\App\Services\SettingService::class);
        $lurahData = $settingService->getLurahData();
        $barcodeImage = $settingService->getBarcodeImage();
    @endphp

    <div class="signature">
        <div class="atas-ttd">
            <p>Parepare, {{ $tanggal }}</p>
            <p>Lurah</p>
        </div>
        @if ($barcodeImage)
            <img src="{{ $barcodeImage }}" alt="Barcode Lurah" class="barcode-img">
        @else
            <div
                style="padding: 8px 15px; background: #f5f5f5; border: 1px dashed #ccc; border-radius: 4px; display: inline-block;">
                <span style="font-size: 9pt; color: #999;">⚠️ Barcode Lurah Belum Diupload</span>
            </div>
        @endif
        <div class="bawah-ttd">
            <p>{{ $lurahData['nama'] }}</p>
            <p>Pangkat : {{ $lurahData['pangkat'] }}</p>
            <p>Nip. {{ $lurahData['nip'] }}</p>
        </div>
    </div>

</body>

</html>
