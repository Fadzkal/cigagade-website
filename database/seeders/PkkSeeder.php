<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class PkkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Resmi Kader TP-PKK Desa Cigagade
        $pkkUser = User::updateOrCreate(
            ['email' => 'pkk@desacigagade.id'],
            [
                'name'              => 'Kader TP-PKK Desa Cigagade',
                'password'          => Hash::make('password123'),
                'role'              => 'pkk',
                'rw'                => null,
                'email_verified_at' => now(),
            ]
        );

        // 2. Kategori TP-PKK Desa
        $categoryPkk = Category::firstOrCreate(
            ['slug' => 'prestasi-ukm'],
            ['name' => 'TP-PKK Desa']
        );

        $categoryKesehatan = Category::firstOrCreate(
            ['slug' => 'institusional'],
            ['name' => 'Layanan & Kesehatan Warga']
        );

        // 3. Contoh Berita & Kegiatan Resmi PKK
        $samplePosts = [
            [
                'category_id'  => $categoryPkk->id,
                'title'        => 'Pemberian Makanan Tambahan (PMT) dan Pemantauan Tumbuh Kembang Balita oleh Kader PKK Cigagade',
                'title_en'     => 'Supplementary Feeding and Child Growth Monitoring by Cigagade PKK Cadres',
                'excerpt'      => 'Kader TP-PKK Desa Cigagade menggelar program penimbangan rutin dan demo pembuatan menu gizi seimbang lokal guna mencegah stunting anak.',
                'excerpt_en'   => 'Cigagade Village PKK cadres held a routine weighing program and a balanced nutrition cooking demo to prevent child stunting.',
                'content'      => '<p>Kader <strong>Tim Penggerak Pemberdayaan dan Kesejahteraan Keluarga (TP-PKK) Desa Cigagade</strong> kembali melaksanakan kegiatan rutin posyandu dan pemantauan tumbuh kembang balita. Kegiatan ini dirangkaikan dengan penyuluhan gizi seimbang serta demo pembuatan Pemberian Makanan Tambahan (PMT) berbahan pangan lokal.</p><p>Ketua TP-PKK Desa Cigagade menyampaikan bahwa peran aktif kader posyandu di setiap dusun dan RW sangat krusial dalam mendeteksi sedini mungkin potensi gangguan pertumbuhan pada balita serta mempercepat penurunan angka stunting di Desa Cigagade.</p>',
                'content_en'   => '<p>Cadres of the <strong>Family Welfare Movement (TP-PKK) of Cigagade Village</strong> conducted routine integrated health post (Posyandu) sessions and child growth monitoring. The event was coupled with balanced nutrition education and cooking demonstrations of supplementary feeding made from local ingredients.</p>',
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id'  => $categoryPkk->id,
                'title'        => 'Gerakan Halaman Asri Teratur Indah dan Nyaman (HATINYA PKK) untuk Ketahanan Pangan Keluarga Cigagade',
                'title_en'     => 'HATINYA PKK Movement for Family Food Security in Cigagade Village',
                'excerpt'      => 'Inovasi pemanfaatan pekarangan rumah dengan tanaman sayuran, obat keluarga (toga), dan budidaya mandiri oleh kelompok Dasawisma PKK Cigagade.',
                'excerpt_en'   => 'Innovative utilization of home yards with vegetables and medicinal herbs by Cigagade PKK Dasawisma groups.',
                'content'      => '<p>Dalam rangka memperkuat ketahanan pangan keluarga di tingkat rumah tangga, <strong>TP-PKK Desa Cigagade</strong> menggalakkan kembali gerakan <em>Halaman Asri, Teratur, Indah dan Nyaman (HATINYA PKK)</em>. Para kader dan ibu-ibu dasawisma diajak memanfaatkan pekarangan rumah masing-masing dengan tanaman pangan seperti cabai, tomat, kangkung, serta tanaman obat keluarga (TOGA).</p><p>Program ini terbukti mampu menghemat pengeluaran dapur keluarga dan mendukung pemenuhan asupan sayur segar yang sehat dan bebas pestisida kimia.</p>',
                'content_en'   => '<p>In order to strengthen household food security, <strong>TP-PKK of Cigagade Village</strong> revitalized the home yard gardening program, encouraging residents to plant fresh vegetables and family medicinal herbs in their home gardens.</p>',
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($samplePosts as $postData) {
            Post::updateOrCreate(
                ['title' => $postData['title']],
                array_merge($postData, [
                    'slug'    => Str::slug($postData['title'], '-'),
                    'slug_en' => Str::slug($postData['title_en'] ?? $postData['title'], '-'),
                    'user_id' => $pkkUser->id,
                    'rw'      => null,
                    'views'   => rand(45, 120),
                ])
            );
        }
    }
}
