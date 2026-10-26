<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class RwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryKabar = Category::firstOrCreate(
            ['slug' => 'kabar-desa'],
            ['name' => 'Kabar Desa']
        );
        $categorySosial = Category::firstOrCreate(
            ['slug' => 'sosial-kemasyarakatan'],
            ['name' => 'Sosial & Kemasyarakatan']
        );
        $categoryPembangunan = Category::firstOrCreate(
            ['slug' => 'pembangunan-infrastruktur'],
            ['name' => 'Pembangunan & Infrastruktur']
        );

        $rwUsers = [];

        // 1. Buat 10 Akun RW (RW 01 s/d RW 10)
        for ($i = 1; $i <= 10; $i++) {
            $rwPadded = str_pad($i, 2, '0', STR_PAD_LEFT);
            $user = User::updateOrCreate(
                ['email' => "rw{$rwPadded}@desacigagade.id"],
                [
                    'name'              => "Pengurus RW {$rwPadded} Desa Cigagade",
                    'password'          => Hash::make('password123'),
                    'role'              => 'rw',
                    'rw'                => $i,
                    'email_verified_at' => now(),
                ]
            );
            $rwUsers[$i] = $user;
        }

        // 2. Berita Contoh untuk RW agar filter langsung dapat diuji
        $sampleRwPosts = [
            [
                'rw'          => 1,
                'category_id' => $categorySosial->id,
                'title'       => 'Gotong Royong Warga RW 01 Bersihkan Drainase dan Lingkungan Jelang Musim Hujan',
                'title_en'    => 'Community Mutual Cooperation in RW 01 Cleans Drainage and Neighborhood Ahead of Rainy Season',
                'excerpt'     => 'Antusiasme warga RW 01 Desa Cigagade dalam kegiatan kerja bakti massal membersihkan saluran air dan peremajaan pos ronda lingkungan.',
                'excerpt_en'  => 'Enthusiasm of RW 01 Cigagade residents in a community cleanup to clear drainage and renovate neighborhood security posts.',
                'content'     => '<p>Warga masyarakat di lingkungan <strong>Rukun Warga (RW) 01 Desa Cigagade</strong> melaksanakan kegiatan kerja bakti gotong royong terpadu pada akhir pekan ini. Kegiatan difokuskan pada pembersihan saluran air (drainase) lingkungan guna mengantisipasi genangan air saat curah hujan tinggi.</p><p>Ketua RW 01 menyampaikan apresiasi setinggi-tingginya kepada seluruh warga yang telah meluangkan waktu dan tenaga. Semangat kegotongroyongan warga Cigagade terus terjaga erat demi kenyamanan dan kebersihan lingkungan bersama.</p>',
                'content_en'  => '<p>Residents of <strong>Neighborhood Unit (RW) 01 of Cigagade Village</strong> held an integrated community cleanup this weekend. The activity focused on clearing drainage channels to prevent waterlogging during periods of high rainfall.</p><p>The head of RW 01 expressed utmost appreciation to all residents for their enthusiastic participation.</p>',
            ],
            [
                'rw'          => 2,
                'category_id' => $categorySosial->id,
                'title'       => 'Layanan Posyandu Melati RW 02: Pemeriksaan Tumbuh Kembang Balita dan Lansia Rutin',
                'title_en'    => 'Melati Integrated Health Post (Posyandu) RW 02: Routine Toddler and Elderly Health Checks',
                'excerpt'     => 'Pelayanan kesehatan berkala di Posyandu Melati RW 02 mencatatkan kehadiran 95% balita dan pemeriksaan tensi serta nutrisi bagi warga lansia.',
                'excerpt_en'  => 'Regular health services at Posyandu Melati RW 02 recorded 95% attendance for toddler growth tracking and health screening for seniors.',
                'content'     => '<p>Kader Posyandu Melati <strong>RW 02 Desa Cigagade</strong> kembali menggelar kegiatan pos pelayanan terpadu bulanan. Selain penimbangan balita dan pemberian vitamin A serta makanan tambahan (PMT), posyandu juga membuka posko cek tensi darah dan konsultasi gizi untuk lansia.</p><p>Kegiatan ini terselenggara berkat kolaborasi erat antara pengurus RW 02, Bidan Desa, dan Tim Penggerak PKK Desa Cigagade.</p>',
                'content_en'  => '<p>Health volunteers at Posyandu Melati in <strong>RW 02 Cigagade</strong> held monthly health service day providing growth monitoring, vitamins, and senior health consultations.</p>',
            ],
            [
                'rw'          => 3,
                'category_id' => $categoryPembangunan->id,
                'title'       => 'Swadaya Warga RW 03 Selesaikan Perbaikan Jalan Gang dan Penerangan Jalan Lingkungan',
                'title_en'    => 'Self-Help Initiative by RW 03 Residents Completes Alley Paving and Solar Street Lights',
                'excerpt'     => 'Dengan gotong royong dan sumbangsih sukarela warga, jalan gang penghubung RT di RW 03 kini telah diperkeras dan dilengkapi lampu hemat energi.',
                'excerpt_en'  => 'Through community solidarity and voluntary contributions, interconnecting alleys in RW 03 have been paved and fitted with energy-efficient street lamps.',
                'content'     => '<p>Pengurus <strong>RW 03 Desa Cigagade</strong> bersama jajaran Ketua RT dan tokoh pemuda sukses menuntaskan program pembenahan akses gang pemukiman. Program ini murni bersumber dari swadaya warga dan gotong royong tenaga secara bergiliran.</p><p>Kini gang pemukiman warga menjadi jauh lebih ramah dan aman bagi anak-anak maupun lansia yang beraktivitas pada malam hari.</p>',
                'content_en'  => '<p>The board of <strong>RW 03 Cigagade</strong> together with RT leaders and youth successfully finalized neighborhood alley improvements through local collective funding.</p>',
            ],
            [
                'rw'          => 5,
                'category_id' => $categoryKabar->id,
                'title'       => 'Revitalisasi Pos Ronda dan Penguatan Sistem Keamanan Lingkungan (Siskamling) di RW 05',
                'title_en'    => 'Revitalization of Neighborhood Watch Post and Siskamling Security System in RW 05',
                'excerpt'     => 'Pengurus RW 05 meresmikan renovasi pos ronda terpadu serta jadwal ronda malam baru demi menjaga ketenteraman dan ketertiban warga.',
                'excerpt_en'  => 'RW 05 board inaugurated the renovated security post and refreshed night patrol schedule to maintain neighborhood peace.',
                'content'     => '<p>Menjaga keamanan dan ketenteraman lingkungan adalah tanggung jawab bersama. Bertempat di pusat wilayah <strong>RW 05 Desa Cigagade</strong>, warga meresmikan selesainya renovasi pos ronda dan pembaruan jadwal ronda malam (siskamling).</p><p>Inisiatif ini disambut hangat oleh segenap warga sebagai wujud kepedulian bersama menjaga kampung tetap aman, damai, dan kondusif.</p>',
                'content_en'  => '<p>Residents of <strong>RW 05 Cigagade Village</strong> celebrated the reopening of their revitalized watch post and community night patrol roster.</p>',
            ],
        ];

        foreach ($sampleRwPosts as $data) {
            $user = $rwUsers[$data['rw']] ?? $rwUsers[1];
            $slug = Str::slug($data['title'], '-');
            $slugEn = Str::slug($data['title_en'], '-');

            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id'      => $user->id,
                    'category_id'  => $data['category_id'],
                    'rw'           => $data['rw'],
                    'title'        => $data['title'],
                    'title_en'     => $data['title_en'],
                    'slug_en'      => $slugEn,
                    'excerpt'      => $data['excerpt'],
                    'excerpt_en'   => $data['excerpt_en'],
                    'content'      => $data['content'],
                    'content_en'   => $data['content_en'],
                    'views'        => rand(45, 230),
                    'published_at' => now()->subDays(rand(1, 10)),
                ]
            );
        }
    }
}
