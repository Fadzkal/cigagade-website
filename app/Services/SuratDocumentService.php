<?php

namespace App\Services;

use App\Models\SuratRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\Border;
use PhpOffice\PhpWord\IOFactory;

class SuratDocumentService
{
    /**
     * Generate PDF stream / download using DomPDF
     */
    public function generatePdf(SuratRequest $surat)
    {
        $pdf = Pdf::loadView('surat.print', [
            'surat' => $surat,
            'isPdf' => true,
        ]);

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);

        $filename = 'SURAT_' . strtoupper($surat->jenis_surat) . '_' . str_replace([' ', '/', '\\'], '_', $surat->nama_lengkap) . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Generate Word document (.docx) using PhpOffice\PhpWord matching template 100%
     */
    public function generateWord(SuratRequest $surat)
    {
        // Pastikan XML escaping aktif agar karakter khusus seperti & tidak merusak format Word (.docx)
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);

        $phpWord = new PhpWord();

        // Default Font & Styling
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        // Section setup (A4, margins 2cm top/bottom, 2.5cm left, 2cm right)
        $section = $phpWord->addSection([
            'paperSize'    => 'A4',
            'marginTop'    => 1134, // ~2.0 cm
            'marginBottom' => 1134, // ~2.0 cm
            'marginLeft'   => 1417, // ~2.5 cm
            'marginRight'  => 1134, // ~2.0 cm
        ]);

        $spec = $surat->data_spesifik ?? [];
        $tglLahirFormat = $surat->tanggal_lahir ? $surat->formatTanggalIndonesia($surat->tanggal_lahir) : '';
        $ttl = trim(($surat->tempat_lahir ? $surat->tempat_lahir . ', ' : '') . $tglLahirFormat, ', ');
        $tglSuratFormat = $surat->tanggal_surat ? $surat->formatTanggalIndonesia($surat->tanggal_surat) : $surat->formatTanggalIndonesia(now());

        // ─── 1. KOP SURAT ───────────────────────────────────────────────
        $kopTable = $section->addTable([
            'alignment' => JcTable::CENTER,
            'cellMargin' => 0,
        ]);
        $kopRow = $kopTable->addRow();

        // Kolom Logo (Kiri)
        $logoCell = $kopRow->addCell(1300, ['valign' => 'center']);
        $logoPath = public_path('LOGO_GARUT.png');
        if (file_exists($logoPath)) {
            $logoCell->addImage($logoPath, [
                'width' => 58,
                'height' => 68,
                'alignment' => Jc::CENTER,
            ]);
        }

        // Kolom Teks Kop (Tengah)
        $textCell = $kopRow->addCell(6800, ['valign' => 'center']);
        $textCell->addText('PEMERINTAH KABUPATEN GARUT', ['bold' => true, 'size' => 13.5], ['alignment' => Jc::CENTER, 'spaceAfter' => 20]);
        $textCell->addText('KECAMATAN BALUBUR LIMBANGAN', ['bold' => true, 'size' => 13], ['alignment' => Jc::CENTER, 'spaceAfter' => 20]);
        $textCell->addText('KEPALA DESA CIGAGADE', ['bold' => true, 'size' => 14.5], ['alignment' => Jc::CENTER, 'spaceAfter' => 40]);
        $textCell->addText('Alamat : Jalan Desa Cigagade No. 03 Balubur Limbangan-Garut 44186', ['size' => 8.5], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);

        // Kolom Penyeimbang (Kanan) agar teks kop simetris di tengah
        $kopRow->addCell(1300, ['valign' => 'center']);

        // Garis Pembatas Kop
        $section->addLine([
            'weight' => 2.5,
            'color' => '000000',
            'height' => 0,
            'width' => 475,
            'spaceBefore' => 50,
            'spaceAfter' => 160,
        ]);

        // ─── 2. JUDUL DAN NOMOR SURAT ───────────────────────────────────
        $section->addText(
            $surat->jenis_info['title'],
            ['bold' => true, 'size' => 11.5, 'underline' => 'single'],
            ['alignment' => Jc::CENTER, 'spaceBefore' => 60, 'spaceAfter' => 20]
        );
        $section->addText(
            'Nomor : ' . $surat->formatted_nomor_surat,
            ['size' => 11],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 180]
        );

        // Helper untuk tambah baris biodata tabel
        $addBioRow = function ($table, $label, $val, $isSub = false) {
            $row = $table->addRow(240);
            $paddingLeft = $isSub ? 200 : 0;
            $row->addCell(2500, ['valign' => 'center'])->addText($label, ['size' => 10.5], ['spaceAfter' => 0, 'indent' => $paddingLeft ? 0.2 : 0]);
            $row->addCell(300, ['valign' => 'center'])->addText(':', ['size' => 10.5], ['spaceAfter' => 0, 'alignment' => Jc::CENTER]);
            $row->addCell(5200, ['valign' => 'center'])->addText($val, ['size' => 10.5], ['spaceAfter' => 0]);
        };

        // ─── 3. ISI SURAT SESUAI TEMPLATE ───────────────────────────────
        switch ($surat->jenis_surat) {

            // ── SKU ──
            case 'sku':
                $section->addText(
                    'Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
                );

                $bioTable = $section->addTable(['cellMargin' => 20]);
                $addBioRow($bioTable, 'Nama Lengkap', $surat->nama_lengkap);
                $addBioRow($bioTable, 'No NIK', $surat->nik);
                $addBioRow($bioTable, 'Tempat Tanggal Lahir', $ttl);
                $addBioRow($bioTable, 'Jenis Kelamin', $surat->jenis_kelamin);
                $addBioRow($bioTable, 'Warga Negara', $surat->warga_negara);
                $addBioRow($bioTable, 'Status Perkawinan', $surat->status_perkawinan);
                $addBioRow($bioTable, 'Pekerjaan', $surat->pekerjaan);
                $addBioRow($bioTable, 'Agama', $surat->agama);
                $addBioRow($bioTable, 'Alamat', $surat->alamat);
                $addBioRow($bioTable, 'RT/RW', $surat->rt . '/' . $surat->rw, true);
                $addBioRow($bioTable, 'Kel/Desa', $surat->desa, true);
                $addBioRow($bioTable, 'Kecamatan', $surat->kecamatan, true);
                $addBioRow($bioTable, 'Kab/Kota', $surat->kabupaten, true);

                $namaUsaha = $spec['nama_usaha'] ?? 'Usaha Kuliner (Bakso Tahu & Cuangki)';
                $alamatUsaha = $spec['alamat_usaha'] ?? 'Kp. Krajan RT 14 RW 02, Desa Sukadami, Wanayasa, Purwakarta';
                $keperluan = $surat->keperluan ?? 'Persyaratan Credit BANK';

                $p1 = $section->addTextRun(['alignment' => Jc::BOTH, 'spaceBefore' => 120, 'spaceAfter' => 80]);
                $p1->addText('Berdasarkan Keterangan dari RT dan RW setempat serta menurut data perekonomian yang terdapat di kantor kami, bahwa orang tersebut diatas mempunyai usaha dibidang ');
                $p1->addText($namaUsaha, ['bold' => true]);
                $p1->addText(' yang terletak di ' . $alamatUsaha . '.');

                $p2 = $section->addTextRun(['alignment' => Jc::BOTH, 'spaceAfter' => 100]);
                $p2->addText('Surat Keterangan Usaha ini dipergunakan untuk : ');
                $p2->addText($keperluan, ['bold' => true]);

                $section->addText(
                    'Demikian Surat Keterangan ini kami buat dengan sebenarnya agar menjadi tahu dan maklum serta untuk dijadikan bahan pertimbangan bagi pihak-pihak terkait.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 160]
                );
                break;

            // ── SKBB ──
            case 'skbb':
                $section->addText(
                    'Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
                );

                $bioTable = $section->addTable(['cellMargin' => 20]);
                $addBioRow($bioTable, 'Nama Lengkap', $surat->nama_lengkap);
                $addBioRow($bioTable, 'No NIK', $surat->nik);
                $addBioRow($bioTable, 'Tempat Tanggal Lahir', $ttl);
                $addBioRow($bioTable, 'Jenis Kelamin', $surat->jenis_kelamin);
                $addBioRow($bioTable, 'Warga Negara', $surat->warga_negara);
                $addBioRow($bioTable, 'Status Perkawinan', $surat->status_perkawinan);
                $addBioRow($bioTable, 'Pekerjaan', $surat->pekerjaan);
                $addBioRow($bioTable, 'Agama', $surat->agama);
                $addBioRow($bioTable, 'Alamat', $surat->alamat);
                $addBioRow($bioTable, 'RT/RW', $surat->rt . '/' . $surat->rw, true);
                $addBioRow($bioTable, 'Kel/Desa', $surat->desa, true);
                $addBioRow($bioTable, 'Kecamatan', $surat->kecamatan, true);
                $addBioRow($bioTable, 'Kab/Kota', $surat->kabupaten, true);

                $section->addText(
                    'Berdasarkan penelitian dan sepengetahuan serta data yang terdapat di Kantor kami bahwa orang tersebut di atas adalah:',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceBefore' => 100, 'spaceAfter' => 40]
                );

                $poinTable = $section->addTable(['cellMargin' => 10]);
                $poinList = [
                    '1.' => 'Penduduk Desa Cigagade',
                    '2.' => 'Berkelakuan baik dalam kehidupan bermasyarakat',
                    '3.' => 'Tidak pernah terlibat penggunaan obat terlarang',
                    '4.' => 'Tidak dalam status tahanan pihak berwajib',
                ];
                foreach ($poinList as $num => $desc) {
                    $row = $poinTable->addRow(220);
                    $row->addCell(400)->addText($num, ['size' => 10.5], ['spaceAfter' => 0]);
                    $row->addCell(7600)->addText($desc, ['size' => 10.5], ['spaceAfter' => 0]);
                }

                $pKeperluan = $section->addTextRun(['alignment' => Jc::BOTH, 'spaceBefore' => 80, 'spaceAfter' => 80]);
                $pKeperluan->addText('Surat Keterangan ini diberikan kepada yang bersangkutan untuk ');
                $pKeperluan->addText($surat->keperluan ?? 'Kelengkapan Credit Bank', ['bold' => true]);
                $pKeperluan->addText('.');

                $section->addText(
                    'Demikian Surat Keterangan ini kami buat untuk dipergunakan seperlunya agar yang berkepentingan menjadi maklum.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 160]
                );
                break;

            // ── SKD ──
            case 'skd':
                $section->addText(
                    'Yang bertandatangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, menerangkan bahwa :',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
                );

                $bioTable = $section->addTable(['cellMargin' => 20]);
                $addBioRow($bioTable, 'No NIK', $surat->nik);
                $addBioRow($bioTable, 'Nama Lengkap', $surat->nama_lengkap);
                $addBioRow($bioTable, 'Jenis Kelamin', $surat->jenis_kelamin);
                $addBioRow($bioTable, 'Tempat Tanggal Lahir', $ttl);
                $addBioRow($bioTable, 'Warga Negara', $surat->warga_negara);
                $addBioRow($bioTable, 'Status Perkawinan', $surat->status_perkawinan);
                $addBioRow($bioTable, 'Pekerjaan', $surat->pekerjaan);
                $addBioRow($bioTable, 'Agama', $surat->agama);
                $addBioRow($bioTable, 'Alamat', $surat->alamat);
                $addBioRow($bioTable, 'RT/RW', $surat->rt . '/' . $surat->rw, true);
                $addBioRow($bioTable, 'Kel/Desa', $surat->desa, true);
                $addBioRow($bioTable, 'Kecamatan', $surat->kecamatan, true);
                $addBioRow($bioTable, 'Kab/Kota', $surat->kabupaten, true);

                $section->addText(
                    'Berdasarkan Keterangan dari RT/RW setempat, serta menurut Data yang terdapat di Kantor kami, bahwa orang tersebut pada saat ini berdomisili di alamat tersebut diatas.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceBefore' => 120, 'spaceAfter' => 100]
                );

                $section->addText(
                    'Demikian Surat Keterangan Domisili ini kami buat dengan sebenarnya mohon yang berkepentingan menjadi tahu serta dapat memberikan kelancaran sebagaimana mestinya.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 160]
                );
                break;

            // ── SKTM ──
            case 'sktm':
                $section->addText(
                    'Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
                );

                $bioTable = $section->addTable(['cellMargin' => 20]);
                $addBioRow($bioTable, 'Nama', $surat->nama_lengkap);
                $addBioRow($bioTable, 'Nomor Induk Kependudukan', $surat->nik);
                $addBioRow($bioTable, 'Tempat dan Tanggal Lahir', $ttl);
                $addBioRow($bioTable, 'Jenis Kelamin', $surat->jenis_kelamin);
                $addBioRow($bioTable, 'Status Perkawinan', $surat->status_perkawinan);
                $addBioRow($bioTable, 'Warga Negara', $surat->warga_negara);
                $addBioRow($bioTable, 'Agama', $surat->agama);
                $addBioRow($bioTable, 'Pekerjaan', $surat->pekerjaan);
                $addBioRow($bioTable, 'Alamat', $surat->alamat);
                $addBioRow($bioTable, 'RT/RW', $surat->rt . '/' . $surat->rw, true);
                $addBioRow($bioTable, 'Desa', $surat->desa, true);
                $addBioRow($bioTable, 'Kecamatan', $surat->kecamatan, true);
                $addBioRow($bioTable, 'Kabupaten', $surat->kabupaten, true);

                $section->addText(
                    'Berdasarkan pengantar dari RT/RW setempat dan data yang terdapat di Kantor kami, bahwa orang tersebut diatas betul-betul tergolong keluarga yang tidak mampu dan sangat layak mendapatkan bantuan',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceBefore' => 120, 'spaceAfter' => 80]
                );

                $pSktm = $section->addTextRun(['alignment' => Jc::BOTH, 'spaceAfter' => 100]);
                $pSktm->addText('Surat keterangan ini dipergunakan untuk : ');
                $pSktm->addText($surat->keperluan ?? 'Keringanan Biaya di PUSKESMAS', ['bold' => true]);

                $section->addText(
                    'Demikian Surat Keterangan ini kami buat dengan sesungguhnya agar menjadi tahu dan maklum serta untuk dijadikan bahan pertimbangan bagi pihak-pihak terkait.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 160]
                );
                break;

            // ── SKM ──
            case 'skm':
                $section->addText(
                    'Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, menerangkan bahwa :',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 60]
                );

                // Suami
                $section->addText('1. Suami', ['bold' => true, 'size' => 11], ['spaceBefore' => 40, 'spaceAfter' => 30]);
                $bioTableSuami = $section->addTable(['cellMargin' => 15]);
                $addBioRow($bioTableSuami, 'Nama Lengkap', $spec['suami_nama'] ?? $surat->nama_lengkap);
                $addBioRow($bioTableSuami, 'Bin', $spec['suami_bin'] ?? '-');
                $addBioRow($bioTableSuami, 'Jenis Kelamin', $spec['suami_jenis_kelamin'] ?? 'Laki-aki');
                $addBioRow($bioTableSuami, 'Tempat Tanggal Lahir', $spec['suami_ttl'] ?? $ttl);
                $addBioRow($bioTableSuami, 'Agama', $spec['suami_agama'] ?? 'Islam');
                $addBioRow($bioTableSuami, 'Status Perkawinan', $spec['suami_status_perkawinan'] ?? 'Jejaka');
                $addBioRow($bioTableSuami, 'Warga Negara', $spec['suami_warga_negara'] ?? 'Indonesia');
                $addBioRow($bioTableSuami, 'Pekerjaan', $spec['suami_pekerjaan'] ?? 'Buruh Harian Lepas');
                $addBioRow($bioTableSuami, 'Alamat', $spec['suami_alamat'] ?? $surat->alamat);

                // Istri
                $section->addText('2. Istri', ['bold' => true, 'size' => 11], ['spaceBefore' => 60, 'spaceAfter' => 30]);
                $bioTableIstri = $section->addTable(['cellMargin' => 15]);
                $addBioRow($bioTableIstri, 'Nama Lengkap', $spec['istri_nama'] ?? '-');
                $addBioRow($bioTableIstri, 'Binti', $spec['istri_binti'] ?? '-');
                $addBioRow($bioTableIstri, 'Jenis Kelamin', $spec['istri_jenis_kelamin'] ?? 'Perempuan');
                $addBioRow($bioTableIstri, 'Tempat Tanggal Lahir', $spec['istri_ttl'] ?? '-');
                $addBioRow($bioTableIstri, 'Agama', $spec['istri_agama'] ?? 'Islam');
                $addBioRow($bioTableIstri, 'Status Perkawinan', $spec['istri_status_perkawinan'] ?? 'Perawan');
                $addBioRow($bioTableIstri, 'Warga Negara', $spec['istri_warga_negara'] ?? 'Indonesia');
                $addBioRow($bioTableIstri, 'Pekerjaan', $spec['istri_pekerjaan'] ?? 'Mengurus Rumah Tangga');
                $addBioRow($bioTableIstri, 'Alamat', $spec['istri_alamat'] ?? '-');

                $tglNikah = $spec['tanggal_pernikahan'] ?? '25 Oktober 2021';
                $kua = $spec['kua_kecamatan'] ?? 'KUA Bl. Limbangan';
                $section->addText(
                    'Berdasarkan Keterangan dari para saksi dan Wali serta Data yang terdapat di kantor Desa kami bahwa orang tersebut diatas betul-betul sudah Menikah yang Syah pada tanggal ' . $tglNikah . ', dan tidak tercatat di ' . $kua . '.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceBefore' => 80, 'spaceAfter' => 60]
                );

                $pSkm = $section->addTextRun(['alignment' => Jc::BOTH, 'spaceAfter' => 80]);
                $pSkm->addText('Surat Keterangan ini dipergunakan untuk ');
                $pSkm->addText($surat->keperluan ?? 'Persyaratan Isbat Nikah', ['bold' => true]);

                $section->addText(
                    'Demikian Surat Keterangan ini kami buat, agar yang berkepentingan menjadi maklum dan dapat dipergunakan sebagaimana mestinya.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 140]
                );
                break;

            // ── SKBM ──
            case 'skbm':
                $section->addText(
                    'Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
                );

                $bioTable = $section->addTable(['cellMargin' => 20]);
                $addBioRow($bioTable, 'No. NIK', $surat->nik);
                $addBioRow($bioTable, 'Nama Lengkap', $surat->nama_lengkap);
                $addBioRow($bioTable, 'Jenis Kelamin', $surat->jenis_kelamin);
                $addBioRow($bioTable, 'Warga Negara', $surat->warga_negara);
                $addBioRow($bioTable, 'Status Perkawinan', 'Belum Kawin');
                $addBioRow($bioTable, 'Pekerjaan', $surat->pekerjaan);
                $addBioRow($bioTable, 'Agama', $surat->agama);
                $addBioRow($bioTable, 'Alamat', $surat->alamat);
                $addBioRow($bioTable, 'RT/RW', $surat->rt . '/' . $surat->rw, true);
                $addBioRow($bioTable, 'Kel/Desa', $surat->desa, true);
                $addBioRow($bioTable, 'Kecamatan', $surat->kecamatan, true);
                $addBioRow($bioTable, 'Kabupaten', $surat->kabupaten, true);

                $pSkbm = $section->addTextRun(['alignment' => Jc::BOTH, 'spaceBefore' => 120, 'spaceAfter' => 100]);
                $pSkbm->addText('Berdasarkan Surat Pernyataan dari yang bersangkutan dan yang diketahui oleh ketua RT. ' . ($spec['pernyataan_rt'] ?? $surat->rt) . ' RW. ' . ($spec['pernyataan_rw'] ?? $surat->rw) . ' bahwa Nama orang tersebut diatas adalah benar-benar penduduk Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut dan yang bersangkutan ');
                $pSkbm->addText('Belum Pernah Melakukan Pernikahan', ['bold' => true, 'underline' => 'single']);
                $pSkbm->addText('.');

                $section->addText(
                    'Demikian Surat Keterangan ini kami buat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya, mohon kepada pihak yang berkepentingan agar menjadi maklum serta mengetahui adanya.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 160]
                );
                break;

            // ── SKP ──
            case 'skp':
                $section->addText(
                    'Yang bertanda tangan dibawah ini Kepala Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut, dengan ini menerangkan bahwa :',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
                );

                $bioTable = $section->addTable(['cellMargin' => 20]);
                $addBioRow($bioTable, 'No. NIK', $surat->nik);
                $addBioRow($bioTable, 'Nama Lengkap', $surat->nama_lengkap);
                $addBioRow($bioTable, 'Jenis Kelamin', $surat->jenis_kelamin);
                $addBioRow($bioTable, 'Tempat Tanggal Lahir', $ttl);
                $addBioRow($bioTable, 'Warga Negara', $surat->warga_negara);
                $addBioRow($bioTable, 'Status Perkawinan', $surat->status_perkawinan);
                $addBioRow($bioTable, 'Pekerjaan', $surat->pekerjaan);
                $addBioRow($bioTable, 'Agama', $surat->agama);
                $addBioRow($bioTable, 'Alamat', $surat->alamat);
                $addBioRow($bioTable, 'RT/RW', $surat->rt . '/' . $surat->rw, true);
                $addBioRow($bioTable, 'Kel/Desa', $surat->desa, true);
                $addBioRow($bioTable, 'Kecamatan', $surat->kecamatan, true);
                $addBioRow($bioTable, 'Kabupaten', $surat->kabupaten, true);

                $section->addText(
                    'Berdasarkan Surat Pernyataan dari yang bersangkutan dan yang diketahui oleh ketua RT. ' . ($spec['pernyataan_rt'] ?? $surat->rt) . ' RW. ' . ($spec['pernyataan_rw'] ?? $surat->rw) . ' bahwa Nama orang tersebut diatas adalah benar-benar penduduk Desa Cigagade Kecamatan Balubur Limbangan Kabupaten Garut dan yang bersangkutan diketahui pekerjaannya adalah ' . $surat->pekerjaan . ' dengan penghasilan sebagai berikut :',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceBefore' => 120, 'spaceAfter' => 80]
                );

                $nominal = isset($spec['penghasilan_perbulan']) ? number_format((float)$spec['penghasilan_perbulan'], 0, ',', '.') : '500.000';
                $terbilang = $spec['penghasilan_terbilang'] ?? SuratRequest::terbilang((float)($spec['penghasilan_perbulan'] ?? 500000));

                $section->addText(
                    'Terima Rata-rata Perbulan : Rp. ' . $nominal . ',- (' . $terbilang . ')',
                    ['bold' => true, 'size' => 11],
                    ['indent' => 0.3, 'spaceAfter' => 80]
                );

                $pSkp = $section->addTextRun(['alignment' => Jc::BOTH, 'spaceAfter' => 100]);
                $pSkp->addText('Surat Keterangan ini dibuat Untuk Persyaratan ');
                $pSkp->addText($surat->keperluan ?? 'Melanjutkan Pendidikan Ke perguruan Tinggi', ['bold' => true]);

                $section->addText(
                    'Demikian Surat Keterangan ini dibuat dan diberikan kepada yang bersangkutan apabila dikemudian hari terdapat kekeliruan akan diperbaiki sebagaimana mestinya.',
                    ['size' => 11],
                    ['alignment' => Jc::BOTH, 'spaceAfter' => 160]
                );
                break;
        }

        // ─── 4. BLOK TANDA TANGAN KEPALA DESA ───────────────────────────
        $ttdTable = $section->addTable(['alignment' => JcTable::END]);
        $ttdRow = $ttdTable->addRow();
        $ttdCell = $ttdRow->addCell(4000);

        $ttdCell->addText('Cigagade, ' . $tglSuratFormat, ['size' => 11], ['alignment' => Jc::CENTER, 'spaceAfter' => 20]);
        $ttdCell->addText($surat->jabatan_kades ?? 'Kepala Desa Cigagade', ['size' => 11], ['alignment' => Jc::CENTER, 'spaceAfter' => 1000]); // 1000 twips = space ttd
        $ttdCell->addText(
            $surat->nama_kades ?? 'DEVI FAHRUROJI, S.Pd.I.',
            ['bold' => true, 'size' => 11, 'underline' => 'single'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 0]
        );

        // Simpan ke temporary file dan kirim download
        $filename = 'SURAT_' . strtoupper($surat->jenis_surat) . '_' . str_replace([' ', '/', '\\'], '_', $surat->nama_lengkap) . '.docx';
        $tempPath = storage_path('app/temp_' . uniqid() . '.docx');

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }
}
