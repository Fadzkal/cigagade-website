<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $surat->jenis_info['title'] }} - {{ $surat->nama_lengkap }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm 2cm 1.5cm 2cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.35;
            color: #000000;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        /* Container saat preview di browser */
        .page-container {
            width: 100%;
            max-width: 21cm;
            margin: 0 auto;
            background: #ffffff;
            box-sizing: border-box;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .kop-logo {
            width: 80px;
            text-align: center;
            vertical-align: middle;
            padding-right: 12px;
        }

        .kop-logo img {
            width: 75px;
            height: auto;
            max-height: 90px;
        }

        .kop-text {
            text-align: center;
            vertical-align: middle;
            padding-right: 80px; /* Seimbangkan logo di kiri */
        }

        .kop-instansi {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.5px;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .kop-kecamatan {
            font-size: 13.5pt;
            font-weight: bold;
            margin: 1px 0 0 0;
            letter-spacing: 0.5px;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .kop-desa {
            font-size: 15pt;
            font-weight: bold;
            margin: 2px 0 0 0;
            letter-spacing: 1px;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .kop-alamat {
            font-size: 9pt;
            margin: 4px 0 0 0;
            line-height: 1.15;
        }

        .kop-line {
            border-top: 3px solid #000000;
            border-bottom: 1px solid #000000;
            height: 2px;
            margin-top: 4px;
            margin-bottom: 18px;
        }

        /* Judul Surat */
        .judul-surat-box {
            text-align: center;
            margin-bottom: 18px;
        }

        .judul-surat {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 2px 0;
        }

        .nomor-surat {
            font-size: 11pt;
            font-weight: normal;
            margin: 0;
        }

        /* Paragraf & Text */
        p {
            margin: 0 0 8px 0;
            text-align: justify;
            text-justify: inter-word;
            line-height: 1.35;
        }

        .pembuka {
            margin-bottom: 8px;
            line-height: 1.35;
        }

        /* Tabel Biodata */
        .bio-table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 20px;
            margin-bottom: 10px;
        }

        .bio-table td {
            padding: 1.5px 0;
            vertical-align: top;
            font-size: 11pt;
            line-height: 1.3;
        }

        .bio-table td.label-col {
            width: 190px;
            white-space: nowrap;
        }

        .bio-table td.sep-col {
            width: 15px;
            text-align: center;
        }

        .bio-table td.val-col {
            padding-left: 4px;
        }

        .sub-heading {
            font-weight: bold;
            margin: 8px 0 4px 10px;
            font-size: 11pt;
        }

        /* Tanda Tangan */
        .ttd-box {
            width: 100%;
            margin-top: 25px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            vertical-align: top;
        }

        .ttd-kanan {
            width: 250px;
            text-align: center;
            font-size: 11pt;
            line-height: 1.25;
        }

        .ttd-space {
            height: 75px;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        /* No-print toolbar */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: none;
                margin: 0;
                padding: 0;
            }
            .page-container {
                box-shadow: none;
                padding: 0;
            }
        }

        .print-toolbar {
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 9999;
            background: #ffffff;
            padding: 10px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            display: flex;
            gap: 10px;
            align-items: center;
            border: 1px solid #e2e8f0;
            font-family: system-ui, sans-serif;
        }

        .btn-print {
            background: #059669;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-print:hover {
            background: #047857;
        }

        .btn-back {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-word {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
    </style>
</head>
<body>

    @if(!isset($isPdf))
    <div class="print-toolbar no-print">
        <span style="font-size: 12px; font-weight: 600; color: #64748b;">Pratinjau Dokumen Cetak</span>
        <a href="{{ route('surat.admin.word', $surat->id) }}" class="btn-word">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H4z"/><path d="M4.5 4a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zM4 6.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/></svg>
            Unduh Word (.docx)
        </a>
        <a href="{{ route('surat.admin.pdf', $surat->id) }}" class="btn-print" style="background:#dc2626;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
            Unduh PDF
        </a>
        <button onclick="window.print()" class="btn-print">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/></svg>
            Cetak Dokumen
        </button>
        <a href="{{ route('surat.admin.index') }}" class="btn-back">Tutup Preview</a>
    </div>
    @endif

    <div class="page-container">

        {{-- KOP SURAT RESMI PEMDES CIGAGADE --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    @php
                        $logoLocal = public_path('LOGO_GARUT.png');
                        $logoData = file_exists($logoLocal) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoLocal)) : asset('LOGO_GARUT.png');
                    @endphp
                    <img src="{{ $logoData }}" alt="Logo Garut">
                </td>
                <td class="kop-text">
                    <div class="kop-instansi">PEMERINTAH KABUPATEN GARUT</div>
                    <div class="kop-kecamatan">KECAMATAN BALUBUR LIMBANGAN</div>
                    <div class="kop-desa">KEPALA DESA CIGAGADE</div>
                    <div class="kop-alamat">Alamat : Jalan Desa Cigagade No. 03 Balubur Limbangan-Garut 44186</div>
                </td>
            </tr>
        </table>

        <div class="kop-line"></div>

        {{-- JUDUL DAN NOMOR SURAT --}}
        <div class="judul-surat-box">
            <div class="judul-surat">{{ $surat->jenis_info['title'] }}</div>
            <div class="nomor-surat">Nomor : {{ $surat->formatted_nomor_surat }}</div>
        </div>

        @php
            $spec = $surat->data_spesifik ?? [];
            $tglLahirFormat = $surat->tanggal_lahir ? $surat->formatTanggalIndonesia($surat->tanggal_lahir) : '';
            $ttl = trim(($surat->tempat_lahir ? $surat->tempat_lahir . ', ' : '') . $tglLahirFormat, ', ');
            $tglSuratFormat = $surat->tanggal_surat ? $surat->formatTanggalIndonesia($surat->tanggal_surat) : $surat->formatTanggalIndonesia(now());
        @endphp

        {{-- ======================================================================== --}}
        {{-- 1. SURAT KETERANGAN USAHA (SKU) --}}
        {{-- ======================================================================== --}}
        @if($surat->jenis_surat === 'sku')
            <p class="pembuka">Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :</p>

            <table class="bio-table">
                <tr><td class="label-col">Nama Lengkap</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nama_lengkap }}</td></tr>
                <tr><td class="label-col">No NIK</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nik }}</td></tr>
                <tr><td class="label-col">Tempat Tanggal Lahir</td><td class="sep-col">:</td><td class="val-col">{{ $ttl }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $surat->jenis_kelamin }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $surat->warga_negara }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->status_perkawinan }}</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->pekerjaan }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $surat->agama }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $surat->alamat }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">RT/RW</td><td class="sep-col">:</td><td class="val-col">{{ $surat->rt }}/{{ $surat->rw }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kel/Desa</td><td class="sep-col">:</td><td class="val-col">{{ $surat->desa }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kecamatan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kecamatan }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kab/Kota</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kabupaten }}</td></tr>
            </table>

            <p style="margin-top: 10px;">Berdasarkan Keterangan dari RT dan RW setempat serta menurut data perekonomian yang terdapat di kantor kami, bahwa orang tersebut diatas mempunyai usaha dibidang <strong>{{ $spec['nama_usaha'] ?? 'Usaha Perdagangan' }}</strong> yang terletak di {{ $spec['alamat_usaha'] ?? $surat->alamat }}.</p>

            <p style="margin-top: 10px;">Surat Keterangan Usaha ini dipergunakan untuk : <strong>{{ $surat->keperluan ?? 'Persyaratan Administrasi' }}</strong></p>

            <p style="margin-top: 10px;">Demikian Surat Keterangan ini kami buat dengan sebenarnya agar menjadi tahu dan maklum serta untuk dijadikan bahan pertimbangan bagi pihak-pihak terkait.</p>

        {{-- ======================================================================== --}}
        {{-- 2. SURAT KETERANGAN BERKELAKUAN BAIK (SKBB) --}}
        {{-- ======================================================================== --}}
        @elseif($surat->jenis_surat === 'skbb')
            <p class="pembuka">Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :</p>

            <table class="bio-table">
                <tr><td class="label-col">Nama Lengkap</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nama_lengkap }}</td></tr>
                <tr><td class="label-col">No NIK</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nik }}</td></tr>
                <tr><td class="label-col">Tempat Tanggal Lahir</td><td class="sep-col">:</td><td class="val-col">{{ $ttl }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $surat->jenis_kelamin }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $surat->warga_negara }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->status_perkawinan }}</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->pekerjaan }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $surat->agama }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $surat->alamat }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">RT/RW</td><td class="sep-col">:</td><td class="val-col">{{ $surat->rt }}/{{ $surat->rw }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kel/Desa</td><td class="sep-col">:</td><td class="val-col">{{ $surat->desa }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kecamatan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kecamatan }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kab/Kota</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kabupaten }}</td></tr>
            </table>

            <p style="margin-top: 10px;">Berdasarkan penelitian dan sepengetahuan serta data yang terdapat di Kantor kami bahwa orang tersebut di atas adalah:</p>
            <table style="width: 100%; margin-left: 15px; margin-bottom: 8px;">
                <tr><td style="width: 25px; vertical-align: top;">1.</td><td>Penduduk Desa Cigagade</td></tr>
                <tr><td style="width: 25px; vertical-align: top;">2.</td><td>Berkelakuan baik dalam kehidupan bermasyarakat</td></tr>
                <tr><td style="width: 25px; vertical-align: top;">3.</td><td>Tidak pernah terlibat penggunaan obat terlarang</td></tr>
                <tr><td style="width: 25px; vertical-align: top;">4.</td><td>Tidak dalam status tahanan pihak berwajib</td></tr>
            </table>

            <p>Surat Keterangan ini diberikan kepada yang bersangkutan untuk <strong>{{ $surat->keperluan ?? 'Kelengkapan Administrasi' }}</strong>.</p>

            <p style="margin-top: 10px;">Demikian Surat Keterangan ini kami buat untuk dipergunakan seperlunya agar yang berkepentingan menjadi maklum.</p>

        {{-- ======================================================================== --}}
        {{-- 3. SURAT KETERANGAN DOMISILI (SKD) --}}
        {{-- ======================================================================== --}}
        @elseif($surat->jenis_surat === 'skd')
            <p class="pembuka">Yang bertandatangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, menerangkan bahwa :</p>

            <table class="bio-table">
                <tr><td class="label-col">No NIK</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nik }}</td></tr>
                <tr><td class="label-col">Nama Lengkap</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nama_lengkap }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $surat->jenis_kelamin }}</td></tr>
                <tr><td class="label-col">Tempat Tanggal Lahir</td><td class="sep-col">:</td><td class="val-col">{{ $ttl }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $surat->warga_negara }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->status_perkawinan }}</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->pekerjaan }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $surat->agama }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $surat->alamat }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">RT/RW</td><td class="sep-col">:</td><td class="val-col">{{ $surat->rt }}/{{ $surat->rw }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kel/Desa</td><td class="sep-col">:</td><td class="val-col">{{ $surat->desa }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kecamatan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kecamatan }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kab/Kota</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kabupaten }}</td></tr>
            </table>

            <p style="margin-top: 10px;">Berdasarkan Keterangan dari RT/RW setempat, serta menurut Data yang terdapat di Kantor kami, bahwa orang tersebut pada saat ini berdomisili di alamat tersebut diatas.</p>

            <p style="margin-top: 10px;">Demikian Surat Keterangan Domisili ini kami buat dengan sebenarnya mohon yang berkepentingan menjadi tahu serta dapat memberikan kelancaran sebagaimana mestinya.</p>

        {{-- ======================================================================== --}}
        {{-- 4. SURAT KETERANGAN TIDAK MAMPU (SKTM) --}}
        {{-- ======================================================================== --}}
        @elseif($surat->jenis_surat === 'sktm')
            <p class="pembuka">Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa</p>

            <table class="bio-table">
                <tr><td class="label-col">Nama</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nama_lengkap }}</td></tr>
                <tr><td class="label-col">Nomor Induk Kependudukan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nik }}</td></tr>
                <tr><td class="label-col">Tempat dan Tanggal Lahir</td><td class="sep-col">:</td><td class="val-col">{{ $ttl }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $surat->jenis_kelamin }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->status_perkawinan }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $surat->warga_negara }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $surat->agama }}</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->pekerjaan }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $surat->alamat }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">RT/RW</td><td class="sep-col">:</td><td class="val-col">{{ $surat->rt }}/{{ $surat->rw }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Desa</td><td class="sep-col">:</td><td class="val-col">{{ $surat->desa }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kecamatan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kecamatan }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kabupaten</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kabupaten }}</td></tr>
            </table>

            <p style="margin-top: 10px;">Berdasarkan pengantar dari RT/RW setempat dan data yang terdapat di Kantor kami, bahwa orang tersebut diatas betul-betul tergolong keluarga yang tidak mampu dan sangat layak mendapatkan bantuan</p>

            <p style="margin-top: 10px;">Surat keterangan ini dipergunakan untuk : <strong>{{ $surat->keperluan ?? 'Keringanan Biaya di PUSKESMAS' }}</strong></p>

            <p style="margin-top: 10px;">Demikian Surat Keterangan ini kami buat dengan sesungguhnya agar menjadi tahu dan maklum serta untuk dijadikan bahan pertimbangan bagi pihak-pihak terkait.</p>

        {{-- ======================================================================== --}}
        {{-- 5. SURAT KETERANGAN MENIKAH (SKM) --}}
        {{-- ======================================================================== --}}
        @elseif($surat->jenis_surat === 'skm')
            <p class="pembuka">Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, menerangkan bahwa :</p>

            <div class="sub-heading">1. Suami</div>
            <table class="bio-table">
                <tr><td class="label-col">Nama Lengkap</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_nama'] ?? $surat->nama_lengkap }}</td></tr>
                <tr><td class="label-col">Bin</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_bin'] ?? '-' }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_jenis_kelamin'] ?? 'Laki-aki' }}</td></tr>
                <tr><td class="label-col">Tempat Tanggal Lahir</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_ttl'] ?? $ttl }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_agama'] ?? 'Islam' }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_status_perkawinan'] ?? 'Jejaka' }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_warga_negara'] ?? 'Indonesia' }}</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_pekerjaan'] ?? 'Buruh Harian Lepas' }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $spec['suami_alamat'] ?? $surat->alamat }}</td></tr>
            </table>

            <div class="sub-heading">2. Istri</div>
            <table class="bio-table">
                <tr><td class="label-col">Nama Lengkap</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_nama'] ?? '-' }}</td></tr>
                <tr><td class="label-col">Binti</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_binti'] ?? '-' }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_jenis_kelamin'] ?? 'Perempuan' }}</td></tr>
                <tr><td class="label-col">Tempat Tanggal Lahir</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_ttl'] ?? '-' }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_agama'] ?? 'Islam' }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_status_perkawinan'] ?? 'Perawan' }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_warga_negara'] ?? 'Indonesia' }}</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_pekerjaan'] ?? 'Mengurus Rumah Tangga' }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $spec['istri_alamat'] ?? '-' }}</td></tr>
            </table>

            <p style="margin-top: 8px;">Berdasarkan Keterangan dari para saksi dan Wali serta Data yang terdapat di kantor Desa kami bahwa orang tersebut diatas betul-betul sudah Menikah yang Syah pada tanggal {{ $spec['tanggal_pernikahan'] ?? '25 Oktober 2021' }}, dan tidak tercatat di {{ $spec['kua_kecamatan'] ?? 'KUA Bl. Limbangan' }}.</p>

            <p style="margin-top: 8px;">Surat Keterangan ini dipergunakan untuk <strong>{{ $surat->keperluan ?? 'Persyaratan Isbat Nikah' }}</strong></p>

            <p style="margin-top: 8px;">Demikian Surat Keterangan ini kami buat, agar yang berkepentingan menjadi maklum dan dapat dipergunakan sebagaimana mestinya.</p>

        {{-- ======================================================================== --}}
        {{-- 6. SURAT KETERANGAN BELUM MENIKAH (SKBM) --}}
        {{-- ======================================================================== --}}
        @elseif($surat->jenis_surat === 'skbm')
            <p class="pembuka">Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :</p>

            <table class="bio-table">
                <tr><td class="label-col">No. NIK</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nik }}</td></tr>
                <tr><td class="label-col">Nama Lengkap</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nama_lengkap }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $surat->jenis_kelamin }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $surat->warga_negara }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">Belum Kawin</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->pekerjaan }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $surat->agama }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $surat->alamat }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">RT/RW</td><td class="sep-col">:</td><td class="val-col">{{ $surat->rt }}/{{ $surat->rw }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kel/Desa</td><td class="sep-col">:</td><td class="val-col">{{ $surat->desa }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kecamatan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kecamatan }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kabupaten</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kabupaten }}</td></tr>
            </table>

            <p style="margin-top: 10px;">Berdasarkan Surat Pernyataan dari yang bersangkutan dan yang diketahui oleh ketua RT. {{ $spec['pernyataan_rt'] ?? $surat->rt }} RW. {{ $spec['pernyataan_rw'] ?? $surat->rw }} bahwa Nama orang tersebut diatas adalah benar-benar penduduk Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut dan yang bersangkutan <strong><u>Belum Pernah Melakukan Pernikahan</u></strong>.</p>

            <p style="margin-top: 10px;">Demikian Surat Keterangan ini kami buat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya, mohon kepada pihak yang berkepentingan agar menjadi maklum serta mengetahui adanya.</p>

        {{-- ======================================================================== --}}
        {{-- 7. SURAT KETERANGAN PENGHASILAN (SKP) --}}
        {{-- ======================================================================== --}}
        @elseif($surat->jenis_surat === 'skp')
            <p class="pembuka">Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :</p>

            <table class="bio-table">
                <tr><td class="label-col">No. NIK</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nik }}</td></tr>
                <tr><td class="label-col">Nama Lengkap</td><td class="sep-col">:</td><td class="val-col">{{ $surat->nama_lengkap }}</td></tr>
                <tr><td class="label-col">Jenis Kelamin</td><td class="sep-col">:</td><td class="val-col">{{ $surat->jenis_kelamin }}</td></tr>
                <tr><td class="label-col">Tempat Tanggal Lahir</td><td class="sep-col">:</td><td class="val-col">{{ $ttl }}</td></tr>
                <tr><td class="label-col">Warga Negara</td><td class="sep-col">:</td><td class="val-col">{{ $surat->warga_negara }}</td></tr>
                <tr><td class="label-col">Status Perkawinan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->status_perkawinan }}</td></tr>
                <tr><td class="label-col">Pekerjaan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->pekerjaan }}</td></tr>
                <tr><td class="label-col">Agama</td><td class="sep-col">:</td><td class="val-col">{{ $surat->agama }}</td></tr>
                <tr><td class="label-col">Alamat</td><td class="sep-col">:</td><td class="val-col">{{ $surat->alamat }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">RT/RW</td><td class="sep-col">:</td><td class="val-col">{{ $surat->rt }}/{{ $surat->rw }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kel/Desa</td><td class="sep-col">:</td><td class="val-col">{{ $surat->desa }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kecamatan</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kecamatan }}</td></tr>
                <tr><td class="label-col" style="padding-left: 20px;">Kabupaten</td><td class="sep-col">:</td><td class="val-col">{{ $surat->kabupaten }}</td></tr>
            </table>

            <p style="margin-top: 10px;">Berdasarkan Surat Pernyataan dari yang bersangkutan dan yang diketahui oleh ketua RT. {{ $spec['pernyataan_rt'] ?? $surat->rt }} RW. {{ $spec['pernyataan_rw'] ?? $surat->rw }} bahwa Nama orang tersebut diatas adalah benar-benar penduduk Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut dan yang bersangkutan diketahui pekerjaannya adalah {{ $surat->pekerjaan }} dengan penghasilan sebagai berikut :</p>

            @php
                $nominal = isset($spec['penghasilan_perbulan']) ? number_format((float)$spec['penghasilan_perbulan'], 0, ',', '.') : '500.000';
                $terbilang = $spec['penghasilan_terbilang'] ?? \App\Models\SuratRequest::terbilang((float)($spec['penghasilan_perbulan'] ?? 500000));
            @endphp
            <p style="margin-left: 20px; font-weight: bold; margin-top: 6px; margin-bottom: 6px;">
                Terima Rata-rata Perbulan : Rp. {{ $nominal }},- ({{ $terbilang }})
            </p>

            <p style="margin-top: 10px;">Surat Keterangan ini dibuat Untuk Persyaratan <strong>{{ $surat->keperluan ?? 'Melanjutkan Pendidikan Ke perguruan Tinggi' }}</strong>.</p>

            <p style="margin-top: 10px;">Demikian Surat Keterangan ini dibuat dan diberikan kepada yang bersangkutan apabila dikemudian hari terdapat kekeliruan akan diperbaiki sebagaimana mestinya.</p>
        @endif

        {{-- ======================================================================== --}}
        {{-- BLOK TANDA TANGAN KEPALA DESA --}}
        {{-- ======================================================================== --}}
        <div class="ttd-box">
            <table class="ttd-table">
                <tr>
                    <td></td>
                    <td class="ttd-kanan">
                        <div>Cigagade, {{ $tglSuratFormat }}</div>
                        <div>{{ $surat->jabatan_kades ?? 'Kepala Desa Cigagade' }}</div>
                        <div class="ttd-space"></div>
                        <div class="nama-kades">{{ $surat->nama_kades ?? 'DEVI FAHRUROJI, S.Pd.I.' }}</div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>
