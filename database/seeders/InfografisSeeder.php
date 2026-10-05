<?php

namespace Database\Seeders;

use App\Models\Infografis;
use Illuminate\Database\Seeder;

class InfografisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Infografis::truncate();

        // ==========================================
        // 1. DEMOGRAFI PENDUDUK
        // ==========================================
        $pendudukCards = [
            ['key' => 'total_penduduk', 'title' => 'TOTAL PENDUDUK', 'value' => '1048', 'unit' => 'Jiwa', 'icon' => 'fas fa-users', 'color' => 'emerald', 'order_index' => 1],
            ['key' => 'total_kk', 'title' => 'KEPALA KELUARGA', 'value' => '307', 'unit' => 'Jiwa', 'icon' => 'fas fa-house-user', 'color' => 'blue', 'order_index' => 2],
            ['key' => 'perempuan', 'title' => 'PEREMPUAN', 'value' => '520', 'unit' => 'Jiwa', 'icon' => 'fas fa-person-dress', 'color' => 'pink', 'order_index' => 3],
            ['key' => 'laki_laki', 'title' => 'LAKI-LAKI', 'value' => '528', 'unit' => 'Jiwa', 'icon' => 'fas fa-person', 'color' => 'teal', 'order_index' => 4],
        ];
        foreach ($pendudukCards as $card) {
            Infografis::create(array_merge($card, ['category' => 'penduduk', 'section' => 'summary']));
        }

        // Piramida Umur (Laki-laki vs Perempuan) - persis data referensi screenshot
        $piramida = [
            ['title' => '0-4',   'val_l' => 13, 'val_p' => 19],
            ['title' => '5-9',   'val_l' => 62, 'val_p' => 55],
            ['title' => '10-14', 'val_l' => 59, 'val_p' => 56],
            ['title' => '15-19', 'val_l' => 40, 'val_p' => 51],
            ['title' => '20-24', 'val_l' => 47, 'val_p' => 46],
            ['title' => '25-29', 'val_l' => 63, 'val_p' => 47],
            ['title' => '30-34', 'val_l' => 43, 'val_p' => 40],
            ['title' => '35-39', 'val_l' => 42, 'val_p' => 36],
            ['title' => '40-44', 'val_l' => 30, 'val_p' => 30],
            ['title' => '45-49', 'val_l' => 25, 'val_p' => 29],
            ['title' => '50-54', 'val_l' => 28, 'val_p' => 24],
            ['title' => '55-59', 'val_l' => 23, 'val_p' => 30],
            ['title' => '60-64', 'val_l' => 16, 'val_p' => 12],
            ['title' => '65-69', 'val_l' => 13, 'val_p' => 19],
            ['title' => '70-74', 'val_l' => 7,  'val_p' => 7],
            ['title' => '75-79', 'val_l' => 8,  'val_p' => 8],
            ['title' => '80-84', 'val_l' => 3,  'val_p' => 7],
            ['title' => '85+',   'val_l' => 6,  'val_p' => 4],
        ];
        $order = 1;
        foreach ($piramida as $p) {
            Infografis::create([
                'category' => 'penduduk',
                'section' => 'piramida',
                'key' => 'age_' . str_replace(['-', '+'], ['_', '_plus'], $p['title']),
                'title' => $p['title'],
                'value' => (string)$p['val_l'],
                'value_alt' => (string)$p['val_p'],
                'unit' => 'Jiwa',
                'color' => 'teal',
                'order_index' => $order++,
            ]);
        }

        // Pendidikan
        $pendidikan = [
            ['title' => 'Belum / Tidak Sekolah', 'val' => 142],
            ['title' => 'Tamat SD / Sederajat', 'val' => 388],
            ['title' => 'Tamat SMP / Sederajat', 'val' => 245],
            ['title' => 'Tamat SMA / SMK', 'val' => 215],
            ['title' => 'Diploma / Sarjana (D3/S1/S2)', 'val' => 58],
        ];
        $order = 1;
        foreach ($pendidikan as $item) {
            Infografis::create([
                'category' => 'penduduk',
                'section' => 'pendidikan',
                'key' => 'pendidikan_' . $order,
                'title' => $item['title'],
                'value' => (string)$item['val'],
                'unit' => 'Jiwa',
                'order_index' => $order++,
            ]);
        }

        // Pekerjaan
        $pekerjaan = [
            ['title' => 'Petani / Perkebunan', 'val' => 380],
            ['title' => 'Wiraswasta / Pedagang', 'val' => 195],
            ['title' => 'Buruh Harian / Tani', 'val' => 160],
            ['title' => 'Karyawan Swasta', 'val' => 112],
            ['title' => 'PNS / TNI / POLRI', 'val' => 18],
            ['title' => 'Ibu Rumah Tangga', 'val' => 105],
            ['title' => 'Pelajar / Mahasiswa', 'val' => 78],
        ];
        $order = 1;
        foreach ($pekerjaan as $item) {
            Infografis::create([
                'category' => 'penduduk',
                'section' => 'pekerjaan',
                'key' => 'pekerjaan_' . $order,
                'title' => $item['title'],
                'value' => (string)$item['val'],
                'unit' => 'Jiwa',
                'order_index' => $order++,
            ]);
        }

        // Dusun / Wilayah
        $dusun = [
            ['title' => 'Dusun I Cigagade (RW 01, RW 02)', 'val' => 365, 'alt' => '108 KK'],
            ['title' => 'Dusun II Cigagade (RW 03, RW 04)', 'val' => 355, 'alt' => '102 KK'],
            ['title' => 'Dusun III Cigagade (RW 05, RW 06)', 'val' => 328, 'alt' => '97 KK'],
        ];
        $order = 1;
        foreach ($dusun as $item) {
            Infografis::create([
                'category' => 'penduduk',
                'section' => 'dusun',
                'key' => 'dusun_' . $order,
                'title' => $item['title'],
                'value' => (string)$item['val'],
                'value_alt' => $item['alt'],
                'unit' => 'Jiwa',
                'order_index' => $order++,
            ]);
        }


        // ==========================================
        // 2. APBDES (KEUANGAN DESA)
        // ==========================================
        $apbdesSummary = [
            ['key' => 'apbdes_tahun', 'title' => 'TAHUN ANGGARAN', 'value' => '2024 / 2025', 'unit' => '', 'icon' => 'fas fa-calendar', 'color' => 'blue', 'order_index' => 1],
            ['key' => 'apbdes_pendapatan', 'title' => 'PENDAPATAN DESA', 'value' => '1845620000', 'unit' => 'Rp', 'icon' => 'fas fa-hand-holding-dollar', 'color' => 'emerald', 'order_index' => 2],
            ['key' => 'apbdes_belanja', 'title' => 'BELANJA DESA', 'value' => '1812350000', 'unit' => 'Rp', 'icon' => 'fas fa-money-bill-transfer', 'color' => 'rose', 'order_index' => 3],
            ['key' => 'apbdes_pembiayaan', 'title' => 'PEMBIAYAAN NETTO', 'value' => '35000000', 'unit' => 'Rp', 'icon' => 'fas fa-vault', 'color' => 'amber', 'order_index' => 4],
        ];
        foreach ($apbdesSummary as $card) {
            Infografis::create(array_merge($card, ['category' => 'apbdes', 'section' => 'summary']));
        }

        // Rincian Belanja APBDes
        $belanjaRincian = [
            ['title' => 'Bidang Pelaksanaan Pembangunan Desa', 'val' => '785450000', 'alt' => '43.3%'],
            ['title' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'val' => '540200000', 'alt' => '29.8%'],
            ['title' => 'Bidang Pemberdayaan Masyarakat', 'val' => '240900000', 'alt' => '13.3%'],
            ['title' => 'Bidang Pembinaan Kemasyarakatan', 'val' => '145800000', 'alt' => '8.1%'],
            ['title' => 'Bidang Penanggulangan Bencana & Darurat', 'val' => '100000000', 'alt' => '5.5%'],
        ];
        $order = 1;
        foreach ($belanjaRincian as $item) {
            Infografis::create([
                'category' => 'apbdes',
                'section' => 'rincian',
                'key' => 'belanja_' . $order,
                'title' => $item['title'],
                'value' => $item['val'],
                'value_alt' => $item['alt'],
                'unit' => 'Rp',
                'order_index' => $order++,
            ]);
        }


        // ==========================================
        // 3. STUNTING (KESEHATAN BALITA & IBU)
        // ==========================================
        $stuntingSummary = [
            ['key' => 'total_balita', 'title' => 'TOTAL BALITA DITIMBANG', 'value' => '94', 'unit' => 'Balita', 'icon' => 'fas fa-baby', 'color' => 'blue', 'order_index' => 1],
            ['key' => 'balita_normal', 'title' => 'BALITA GIZI BAIK / NORMAL', 'value' => '88', 'unit' => 'Balita', 'icon' => 'fas fa-heart-pulse', 'color' => 'emerald', 'order_index' => 2],
            ['key' => 'berisiko_stunting', 'title' => 'BERISIKO STUNTING', 'value' => '6', 'unit' => 'Balita', 'icon' => 'fas fa-triangle-exclamation', 'color' => 'amber', 'order_index' => 3],
            ['key' => 'penerima_pmt', 'title' => 'PENERIMA PMT RUTIN', 'value' => '6', 'unit' => 'Balita', 'icon' => 'fas fa-bowl-food', 'color' => 'teal', 'order_index' => 4],
        ];
        foreach ($stuntingSummary as $card) {
            Infografis::create(array_merge($card, ['category' => 'stunting', 'section' => 'summary']));
        }

        $posyandu = [
            ['title' => 'Posyandu Mawar 1 (Dusun I)', 'val' => '26', 'alt' => '1 Balita Perlu Perhatian PMT'],
            ['title' => 'Posyandu Melati 2 (Dusun II)', 'val' => '24', 'alt' => '2 Balita Perlu Perhatian PMT'],
            ['title' => 'Posyandu Anggrek 3 (Dusun III)', 'val' => '22', 'alt' => '2 Balita Perlu Perhatian PMT'],
            ['title' => 'Posyandu Cempaka 4 (Dusun III)', 'val' => '22', 'alt' => '1 Balita Perlu Perhatian PMT'],
        ];
        $order = 1;
        foreach ($posyandu as $item) {
            Infografis::create([
                'category' => 'stunting',
                'section' => 'rincian',
                'key' => 'posyandu_' . $order,
                'title' => $item['title'],
                'value' => $item['val'],
                'value_alt' => $item['alt'],
                'unit' => 'Balita Terdata',
                'order_index' => $order++,
            ]);
        }


        // ==========================================
        // 4. BANSOS (BANTUAN SOSIAL)
        // ==========================================
        $bansosSummary = [
            ['key' => 'total_kpm', 'title' => 'TOTAL KPM TERIMA BANSOS', 'value' => '382', 'unit' => 'KPM', 'icon' => 'fas fa-hand-holding-heart', 'color' => 'indigo', 'order_index' => 1],
            ['key' => 'pkh', 'title' => 'PROGRAM KELUARGA HARAPAN (PKH)', 'value' => '112', 'unit' => 'KPM', 'icon' => 'fas fa-people-roof', 'color' => 'blue', 'order_index' => 2],
            ['key' => 'bpnt', 'title' => 'BPNT / SEMBAKO', 'value' => '146', 'unit' => 'KPM', 'icon' => 'fas fa-basket-shopping', 'color' => 'emerald', 'order_index' => 3],
            ['key' => 'blt_dd', 'title' => 'BLT DANA DESA', 'value' => '48', 'unit' => 'KPM', 'icon' => 'fas fa-money-check-dollar', 'color' => 'amber', 'order_index' => 4],
            ['key' => 'beras_cpp', 'title' => 'CADANGAN PANGAN (CPP)', 'value' => '275', 'unit' => 'KPM', 'icon' => 'fas fa-wheat-awn', 'color' => 'teal', 'order_index' => 5],
        ];
        foreach ($bansosSummary as $card) {
            Infografis::create(array_merge($card, ['category' => 'bansos', 'section' => 'summary']));
        }


        // ==========================================
        // 5. IDM (INDEKS DESA MEMBANGUN)
        // ==========================================
        $idmSummary = [
            ['key' => 'skor_idm', 'title' => 'SKOR IDM DESA', 'value' => '0.7682', 'unit' => '', 'icon' => 'fas fa-award', 'color' => 'emerald', 'order_index' => 1],
            ['key' => 'status_idm', 'title' => 'STATUS KEMAJUAN DESA', 'value' => 'DESA MAJU', 'unit' => '', 'icon' => 'fas fa-crown', 'color' => 'amber', 'order_index' => 2],
            ['key' => 'target_idm', 'title' => 'TARGET TAHUN BERIKUTNYA', 'value' => 'DESA MANDIRI', 'unit' => '', 'icon' => 'fas fa-flag-checkered', 'color' => 'blue', 'order_index' => 3],
            ['key' => 'iks', 'title' => 'INDEKS KETAHANAN SOSIAL (IKS)', 'value' => '0.8120', 'unit' => 'Poin', 'icon' => 'fas fa-user-shield', 'color' => 'teal', 'order_index' => 4],
            ['key' => 'ike', 'title' => 'INDEKS KETAHANAN EKONOMI (IKE)', 'value' => '0.7150', 'unit' => 'Poin', 'icon' => 'fas fa-chart-line', 'color' => 'indigo', 'order_index' => 5],
            ['key' => 'ikl', 'title' => 'INDEKS KETAHANAN LINGKUNGAN (IKL)', 'value' => '0.7775', 'unit' => 'Poin', 'icon' => 'fas fa-leaf', 'color' => 'emerald', 'order_index' => 6],
        ];
        foreach ($idmSummary as $card) {
            Infografis::create(array_merge($card, ['category' => 'idm', 'section' => 'summary']));
        }


        // ==========================================
        // 6. SDGs DESA (18 INDIKATOR LENGKAP)
        // ==========================================
        Infografis::create([
            'category' => 'sdgs',
            'section' => 'summary',
            'key' => 'skor_sdgs_total',
            'title' => 'SKOR SDGs DESA CIGAGADE',
            'value' => '66.85',
            'unit' => '/ 100',
            'icon' => 'fas fa-trophy',
            'color' => 'emerald',
            'order_index' => 1,
        ]);

        $sdgsGoals = [
            ['id' => 1, 'title' => 'Desa Tanpa Kemiskinan', 'score' => '68.4', 'color' => 'rose'],
            ['id' => 2, 'title' => 'Desa Tanpa Kelaparan', 'score' => '72.5', 'color' => 'amber'],
            ['id' => 3, 'title' => 'Desa Sehat dan Sejahtera', 'score' => '82.1', 'color' => 'emerald'],
            ['id' => 4, 'title' => 'Pendidikan Desa Berkualitas', 'score' => '74.0', 'color' => 'red'],
            ['id' => 5, 'title' => 'Keterlibatan Perempuan Desa', 'score' => '70.2', 'color' => 'orange'],
            ['id' => 6, 'title' => 'Desa Layak Air Bersih dan Sanitasi', 'score' => '85.6', 'color' => 'cyan'],
            ['id' => 7, 'title' => 'Desa Berenergi Bersih dan Terbarukan', 'score' => '58.0', 'color' => 'yellow'],
            ['id' => 8, 'title' => 'Pertumbuhan Ekonomi Desa Merata', 'score' => '64.5', 'color' => 'red'],
            ['id' => 9, 'title' => 'Infrastruktur dan Inovasi Desa Sesuai Kebutuhan', 'score' => '71.3', 'color' => 'orange'],
            ['id' => 10, 'title' => 'Desa Tanpa Kesenjangan', 'score' => '66.0', 'color' => 'pink'],
            ['id' => 11, 'title' => 'Kawasan Pemukiman Desa Aman dan Nyaman', 'score' => '75.8', 'color' => 'amber'],
            ['id' => 12, 'title' => 'Konsumsi dan Produksi Desa Sadar Lingkungan', 'score' => '62.4', 'color' => 'green'],
            ['id' => 13, 'title' => 'Tanggap Perubahan Iklim', 'score' => '56.0', 'color' => 'emerald'],
            ['id' => 14, 'title' => 'Peduli Lingkungan Laut', 'score' => '0.0', 'color' => 'blue'],
            ['id' => 15, 'title' => 'Peduli Lingkungan Darat', 'score' => '70.5', 'color' => 'lime'],
            ['id' => 16, 'title' => 'Desa Damai Berkeadilan', 'score' => '80.0', 'color' => 'sky'],
            ['id' => 17, 'title' => 'Kemitraan untuk Pembangunan Desa', 'score' => '73.2', 'color' => 'indigo'],
            ['id' => 18, 'title' => 'Kelembagaan Desa Dinamis & Budaya Adaptif', 'score' => '84.0', 'color' => 'teal'],
        ];

        foreach ($sdgsGoals as $goal) {
            Infografis::create([
                'category' => 'sdgs',
                'section' => 'tujuan',
                'key' => 'sdgs_goal_' . $goal['id'],
                'title' => $goal['id'] . '. ' . $goal['title'],
                'value' => $goal['score'],
                'unit' => '/ 100',
                'color' => $goal['color'],
                'order_index' => $goal['id'],
                'meta' => ['goal_number' => $goal['id']],
            ]);
        }
    }
}
