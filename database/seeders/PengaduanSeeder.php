<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $dummy = [
            [
                'kode_tiket'    => 'PGD-20261025-A101',
                'nama'          => 'Ahmad Hidayat',
                'is_anonim'     => false,
                'kontak'        => '081234567890',
                'kategori'      => 'Infrastruktur & Jalan',
                'judul'         => 'Lampu Penerangan Jalan Mati di Dekat Jembatan RW 03',
                'isi_pengaduan' => 'Mohon bantuan dari pihak Pemdes Cigagade untuk mengecek lampu jalan PJU di tikungan dekat jembatan RW 03 yang sudah mati sejak seminggu lalu. Kondisi jalan cukup gelap saat malam hari dan rawan bagi pengendara motor.',
                'lokasi'        => 'Jalan Dusun 2, Dekat Jembatan RW 03',
                'foto_bukti'    => null,
                'status'        => 'selesai',
                'tanggapan'     => 'Terima kasih atas laporannya Pak Ahmad. Tim teknis Pemdes Cigagade bersama pengurus RW 03 telah mengganti bohlam PJU dan sambungan kabel yang putus pada tanggal 26 Oktober 2026. Lampu saat ini sudah berfungsi normal kembali.',
                'tanggapan_at'  => now()->subDays(2),
                'tanggapan_oleh'=> 'Kepala Seksi Pelayanan & Kesra',
                'is_public'     => true,
                'created_at'    => now()->subDays(3),
            ],
            [
                'kode_tiket'    => 'PGD-20261026-B204',
                'nama'          => null, // Anonim
                'is_anonim'     => true,
                'kontak'        => null,
                'kategori'      => 'Kebersihan & Lingkungan',
                'judul'         => 'Tumpukan Sampah Liar di Pinggir Selokan Perbatasan RW 05',
                'isi_pengaduan' => 'Ada oknum yang membuang sampah rumah tangga dalam kantong plastik di pinggir selokan irigasi RT 02 RW 05. Mengingat musim hujan sudah mulai datang, dikhawatirkan menyumbat aliran air dan menyebabkan genangan.',
                'lokasi'        => 'Pinggir Saluran Irigasi RT 02 / RW 05',
                'foto_bukti'    => null,
                'status'        => 'diproses',
                'tanggapan'     => 'Laporan telah kami terima dan dikoordinasikan dengan Ketua RW 05. Jadwal kerja bakti pembersihan selokan akan diadakan bersama warga setempat pada hari Minggu besok, serta akan dipasang plang larangan buang sampah.',
                'tanggapan_at'  => now()->subDay(),
                'tanggapan_oleh'=> 'Pemerintah Desa Cigagade',
                'is_public'     => true,
                'created_at'    => now()->subDays(2),
            ],
            [
                'kode_tiket'    => 'PGD-20261027-C309',
                'nama'          => 'Ibu Nenden Kurniasih',
                'is_anonim'     => false,
                'kontak'        => '082198765432',
                'kategori'      => 'Pelayanan Desa',
                'judul'         => 'Apresiasi dan Usulan Jam Layanan Tambahan di Kantor Desa',
                'isi_pengaduan' => 'Pelayanan pembuatan surat di kantor desa sangat ramah dan cepat, apalagi sekarang sudah ada layanan surat online KKN. Kalau bisa diusulkan agar hari Sabtu tetap dibuka piket pelayanan setengah hari untuk warga yang bekerja di luar kota saat hari kerja biasa. Nuhun.',
                'lokasi'        => 'Kantor Pelayanan Desa Cigagade',
                'foto_bukti'    => null,
                'status'        => 'selesai',
                'tanggapan'     => 'Hatur nuhun Ibu Nenden atas apresiasi dan masukannya. Usulan layanan piket akhir pekan sedang dikaji bersama BPD agar warga Cigagade yang beraktivitas di luar kota tetap terlayani dengan optimal.',
                'tanggapan_at'  => now()->subHours(10),
                'tanggapan_oleh'=> 'Sekretaris Desa Cigagade',
                'is_public'     => true,
                'created_at'    => now()->subDay(),
            ],
            [
                'kode_tiket'    => 'PGD-20261028-D412',
                'nama'          => 'Dadan Ramdani',
                'is_anonim'     => false,
                'kontak'        => '085712344321',
                'kategori'      => 'Infrastruktur & Jalan',
                'judul'         => 'Jalan Berlubang di Dekat Lapangan Voli RW 01',
                'isi_pengaduan' => 'Ada lubang aspal yang cukup dalam di dekat lapangan voli RW 01 arah Dusun 1. Bila malam hari dan hujan sering tergenang air sehingga tidak terlihat pengendara motor. Mohon dapat ditambal sementara dengan sirtu atau semen.',
                'lokasi'        => 'Akses Jalan Lapangan RW 01',
                'foto_bukti'    => null,
                'status'        => 'menunggu',
                'tanggapan'     => null,
                'tanggapan_at'  => null,
                'tanggapan_oleh'=> null,
                'is_public'     => true,
                'created_at'    => now()->subHours(2),
            ],
        ];

        foreach ($dummy as $item) {
            Pengaduan::updateOrCreate(
                ['kode_tiket' => $item['kode_tiket']],
                $item
            );
        }
    }
}
