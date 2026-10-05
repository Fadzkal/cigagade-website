<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RunningText;

class RunningTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'text' => 'Selamat Datang di Website Resmi Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut',
                'url' => null,
                'badge' => 'INFO',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'text' => 'Layanan Administrasi Surat Mandiri Warga Kini Dapat Diajukan Secara Online 24 Jam',
                'url' => '#',
                'badge' => 'INFO',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'text' => 'Transparansi Data Pembangunan: Pantau Realisasi APBDes dan SDGs Desa Cigagade',
                'url' => '/infografis',
                'badge' => 'INFO',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'text' => 'Kunjungi Destinasi Wisata Religi Sunan Cibalampu & Keasrian Saluran Irigasi Sungai Cipancar',
                'url' => '/berita',
                'badge' => 'INFO',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'text' => 'Dukung Kebangkitan Ekonomi Warga: Jelajahi Produk Unggulan di Katalog UMKM Desa',
                'url' => '/umkm',
                'badge' => 'INFO',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($items as $item) {
            RunningText::firstOrCreate(
                ['text' => $item['text']],
                $item
            );
        }
    }
}
