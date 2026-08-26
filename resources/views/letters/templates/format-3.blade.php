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
            margin-bottom: 15px;
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

    <!-- NOMOR, LAMPIRAN, PERIHAL -->
    <div style="display: flex; justify-content: space-between; font-size: 10pt;" class="header-resmi">
        <div class="container-tabel">
            <table style="width: 100%; margin-top: 10px;">
                <tr>
                    <td style="width: 80px;">Nomor</td>
                    <td style="width: 10px;">:</td>
                    <td>{{-- Ganti $letter_number dengan hardcode 377 --}}
                        {{ '377/' . $letter_number . '/GLM' }}
                    </td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>Permohonan Izin Keramaian</td>
                </tr>
            </table>
        </div>

        <div class="container-kepada">
            <p>Kepada</p>
            <p style="margin-left: 20px;">
                Yth. {{ $tujuan_instansi ?? 'Kapolsekta Bacukiki' }}<br>
                di -<br>
                Parepare
            </p>
        </div>
    </div>

    <!-- ISI SURAT -->
    <div style="font-size: 10pt;" class="content">

        <!-- Yang bertanda tangan -->
        <p>Yang bertanda tangan di bawah ini :</p>
        <table style="margin-left: 20px;">
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td><strong>{{ $pejabat['nama'] ?? 'MUHAMMAD ZULKIFLI FARID, SE' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="separator">:</td>
                <td><strong>Lurah Galung Maloang</strong></td>
            </tr>
        </table>

        <!-- Data Pemohon -->
        <p style="margin-top: 8px">Dengan ini memberikan keterangan bahwa :</p>
        <table style="margin-left: 20px;">
            <tr>
                <td style="width: 45px;">Nama</td>
                <td style="width: 10px;">:</td>
                <td><strong>{{ $user->name }}</strong></td>
            </tr>
            <tr>
                <td>Tempat/Tgl.Lahir</td>
                <td>:</td>
                <td>{{ $user->tempat_lahir ?? '-' }},
                    {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $user->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $user->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $user->alamat ?? '-' }}</td>
            </tr>
        </table>
        <!-- Narasi -->
        <p style="margin-top: 8px">
            Bahwa yang tersebut namanya di atas adalah benar penduduk Kelurahan Galung Maloang
            Kecamatan Bacukiki Kota Parepare.
        </p>

        <!-- Detail acara (untuk Izin Keramaian) -->
        @if ($application->service_id == 5)
            <p>
                dengan ini memberikan pengantar izin Keramaian untuk acara yang akan diselenggarakan pada :
            </p>
            <table style="margin-left: 20px;">
                <tr>
                    <td style="width: 80px;">Hari/Tanggal</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $application->data['hari_tanggal'] ?? '___' }}</td>
                </tr>
                <tr>
                    <td>Jam</td>
                    <td>:</td>
                    <td>{{ $application->data['jam'] ?? '___' }}</td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td>:</td>
                    <td>{{ $application->data['tempat'] ?? '___' }}</td>
                </tr>
            </table>
        @endif

        <!-- Konten dinamis dari staff -->
        @if (!empty($content))
            <div style="margin-top: 10px;">
                {!! nl2br(e($content)) !!}
            </div>
        @endif

        <!-- Poin-poin ketentuan (untuk Izin Keramaian) -->
        @if ($application->service_id == 5)
            <p style="margin-top: 8px">Adapun hal-hal yang perlu dipatuhi / ditaati sebagai berikut :</p>
            <div class="poin-ketentuan">
                <p class="poin-ketentuan-item">
                    1. Selama acara berlangsung, tidak diperbolehkan membunyikan musik/sejenisnya lewat dari jam 24.00
                    Wita.
                </p>
                <p class="poin-ketentuan-item">
                    2. Selama acara berlangsung, tidak diperkenankan minum-minuman keras, melakukan penyalahgunaan
                    narkoba dan sejenisnya di lokasi acara.
                </p>
            </div>
        @endif

        <!-- Penutup -->
        <p style="margin-top: 8px">
            Demikian pengantar izin keramaian ini dibuat, untuk dipergunakan sebagaimana mestinya.
        </p>

    </div>

    <!-- TANDA TANGAN & BARCODE -->
    @php
        $settingService = app(\App\Services\SettingService::class);
        $lurahData = $settingService->getLurahData();
        $barcodeImage = $settingService->getBarcodeImage();
    @endphp

    <div style="font-size: 10pt" class="signature">
        <div style="margin-bottom: 10px;" class="atas-ttd">
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
