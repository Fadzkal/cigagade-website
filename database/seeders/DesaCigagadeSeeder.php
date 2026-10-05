<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Post;
use App\Models\Ministry;
use App\Models\Partner;
use App\Models\HeroSlide;
use App\Models\Video;
use App\Models\Gallery;

class DesaCigagadeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@desacigagade.id'],
            [
                'name' => 'Administrator Desa Cigagade',
                'password' => Hash::make('adminCigagade2026!#$'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]
        );

        $staff = User::updateOrCreate(
            ['email' => 'paskalluffy@gmail.com'],
            [
                'name' => 'Fadzkal Luthfi (Admin IT Desa)',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Settings Desa Cigagade
        $settingsData = [
            'about_title'       => 'Selamat Datang di Portal Resmi Desa Cigagade',
            'about_subtitle'    => 'PROFIL PEMERINTAHAN DESA',
            'about_description' => 'Desa Cigagade adalah sebuah desa yang asri, agamis, dan berdaya saing di Kecamatan Balubur Limbangan, Kabupaten Garut, Provinsi Jawa Barat. Terletak di kawasan subur yang dilintasi aliran Sungai Cipancar, Desa Cigagade memiliki potensi pertanian pangan yang melimpah, kerajinan dan UMKM yang kreatif, serta sejarah budaya lokal yang kaya di kawasan Sunan Cibalampu. Kami berkomitmen memberikan pelayanan publik yang ramah, transparan, dan akuntabel untuk kesejahteraan seluruh warga.',
            'visi'              => "Terwujudnya Desa Cigagade yang Maju, Mandiri, Agamis, Berkeadilan, dan Sejahtera Berbasis Potensi Pertanian, UMKM, dan Partisipasi Aktif Masyarakat.",
            'misi'              => "1. Menyelenggarakan tata kelola pemerintahan desa yang bersih, transparan, profesional, dan berbasis pelayanan digital untuk masyarakat.\n2. Meningkatkan pembangunan infrastruktur perdesaan, jalan lingkungan, saluran irigasi Sungai Cipancar, dan sarana sanitasi yang merata.\n3. Mengembangkan potensi ekonomi kerakyatan, penguatan BUMDes Gagade Mandiri, dan pemberdayaan pelaku UMKM lokal.\n4. Mendorong produktivitas sektor pertanian pangan, perkebunan rakyat, dan ketahanan pangan desa.\n5. Meningkatkan kualitas sumber daya manusia, pendidikan keagamaan, serta layanan posyandu dan kesehatan ibu-anak.\n6. Menjaga kelestarian lingkungan hidup, tradisi gotong royong, dan nilai-nilai kearifan lokal budaya Sunda.",
            'video_url'         => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
            'stat_activities'   => '4 Dusun / 8 RW',
            'stat_members'      => '4.850+ Jiwa',
            'stat_programs'     => '18 Program Kerja',
            'stat_partners'     => '12 Instansi & Mitra',
        ];

        foreach ($settingsData as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Kategori (Categories)
        $categoriesList = [
            ['name' => 'Kabar Desa',                     'slug' => 'kabar-desa'],
            ['name' => 'Pemerintahan & Pelayanan',       'slug' => 'pemerintahan-pelayanan'],
            ['name' => 'Pembangunan & Infrastruktur',   'slug' => 'pembangunan-infrastruktur'],
            ['name' => 'Sosial & Kemasyarakatan',       'slug' => 'sosial-kemasyarakatan'],
            ['name' => 'Ekonomi & UMKM',                 'slug' => 'ekonomi-umkm'],
            ['name' => 'Pertanian & Ketahanan Pangan',   'slug' => 'pertanian-ketahanan-pangan'],
            ['name' => 'Prestasi',                       'slug' => 'prestasi'],
            ['name' => 'Pengumuman',                     'slug' => 'pengumuman'],
            // Kategori Kelembagaan (Ormawa mapping)
            ['name' => 'Karang Taruna',                  'slug' => 'kegiatan-ukm'],
            ['name' => 'TP-PKK Desa',                    'slug' => 'prestasi-ukm'],
            ['name' => 'BPD & LPMD',                     'slug' => 'kegiatan-himpunan'],
            ['name' => 'Kelompok Tani & Linmas',         'slug' => 'prestasi-himpunan'],
            // Kategori Potensi & Literasi (Bengkel Ilmu mapping)
            ['name' => 'Pertanian & Irigasi',            'slug' => 'karir-pengembangan-diri'],
            ['name' => 'Inovasi & BUMDes',               'slug' => 'riset-inovasi'],
            ['name' => 'Seni, Budaya & Wisata',          'slug' => 'hiburan'],
            ['name' => 'Layanan & Kesehatan Warga',      'slug' => 'institusional'],
        ];

        $catMap = [];
        foreach ($categoriesList as $catItem) {
            $cat = Category::updateOrCreate(
                ['slug' => $catItem['slug']],
                ['name' => $catItem['name']]
            );
            $catMap[$catItem['slug']] = $cat->id;
        }

        // 4. Perangkat Desa (Aparatur Pemerintahan Desa Cigagade)
        $ministries = [
            [
                'name' => 'Devi Fahruroji - Kepala Desa Cigagade',
                'description' => 'Memimpin penyelenggaraan pemerintahan desa, pembinaan kemasyarakatan, pembangunan, dan pemberdayaan warga Desa Cigagade.',
            ],
            [
                'name' => 'Sekretaris Desa (Sekdes)',
                'description' => 'Membantu Kepala Desa dalam bidang administrasi pemerintahan, ketatausahaan, keuangan, dan penyusunan kebijakan peraturan desa.',
            ],
            [
                'name' => 'Kaur Keuangan & Pendapatan',
                'description' => 'Mengelola ketatausahaan keuangan desa, penatausahaan APBDes, dan pelaporan pertanggungjawaban realisasi anggaran.',
            ],
            [
                'name' => 'Kaur Tata Usaha & Umum',
                'description' => 'Membantu urusan ketatausahaan, korespondensi dinas, pengarsipan, inventaris kekayaan desa, serta pelayanan administrasi umum.',
            ],
            [
                'name' => 'Kasi Pelayanan & Kesejahteraan',
                'description' => 'Melaksanakan penyuluhan dan motivasi terhadap hak dan kewajiban masyarakat, pelayanan sosial, posyandu, dan keagamaan.',
            ],
            [
                'name' => 'Kasi Pemerintahan & Keamanan',
                'description' => 'Menyusun rancangan regulasi desa, pembinaan ketenteraman dan ketertiban masyarakat, serta kependudukan.',
            ],
        ];

        foreach ($ministries as $m) {
            Ministry::updateOrCreate(
                ['name' => $m['name']],
                ['description' => $m['description'], 'image' => null]
            );
        }

        // 5. Mitra & Instansi Terkait
        $partners = [
            ['name' => 'Pemerintah Kabupaten Garut',           'type' => 'kerjasama'],
            ['name' => 'Kantor Kecamatan Balubur Limbangan',  'type' => 'kerjasama'],
            ['name' => 'UPT Puskesmas Balubur Limbangan',      'type' => 'kerjasama'],
            ['name' => 'Polsek & Koramil Balubur Limbangan',   'type' => 'kerjasama'],
            ['name' => 'BUMDes Gagade Mandiri',                'type' => 'media_partner'],
            ['name' => 'Bank BJB Garut / Unit Limbangan',      'type' => 'media_partner'],
            ['name' => 'Gapoktan Sari Tani Cigagade',          'type' => 'media_partner'],
        ];

        foreach ($partners as $p) {
            Partner::updateOrCreate(
                ['name' => $p['name']],
                ['type' => $p['type'], 'logo' => 'logos/default-partner.png']
            );
        }

        // 6. Hero Slides
        $slides = [
            [
                'title' => 'Selamat Datang di Portal Resmi Desa Cigagade',
                'type' => 'image',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Transparansi Pelayanan dan Pembangunan Desa Berkelanjutan',
                'type' => 'image',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Gotong Royong Membangun Pertanian dan UMKM Cigagade',
                'type' => 'image',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $sl) {
            HeroSlide::updateOrCreate(
                ['title' => $sl['title']],
                ['type' => $sl['type'], 'order' => $sl['order'], 'is_active' => $sl['is_active']]
            );
        }

        // 7. Berita Desa, Prestasi & Pengumuman
        $samplePosts = [
            // Berita Umum
            [
                'cat' => 'kabar-desa',
                'title' => 'Musrenbangdes Cigagade: Tetapkan Skala Prioritas Infrastruktur Jalan Usaha Tani dan Saluran Irigasi',
                'title_en' => 'Cigagade Village Musrenbang: Setting Priorities for Agricultural Road and Irrigation Infrastructure',
                'slug' => 'musrenbangdes-cigagade-infrastruktur-irigasi',
                'slug_en' => 'cigagade-village-musrenbang-infrastructure',
                'excerpt' => 'Pemerintah Desa Cigagade bersama BPD dan tokoh masyarakat menggelar Musyawarah Perencanaan Pembangunan Desa guna mematangkan usulan pembangunan tahun anggaran mendatang.',
                'excerpt_en' => 'Cigagade Village Government together with BPD and community leaders held a Village Development Planning Meeting to finalize development proposals for the upcoming fiscal year.',
                'content' => '<p>Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut, sukses menyelenggarakan Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) yang dihadiri oleh Kepala Desa, jajaran BPD, LPMD, Ketua RT/RW, tokoh agama, tokoh pemuda Karang Taruna, serta pendamping desa.</p><p>Fokus utama usulan pembangunan mencakup pengerasan jalan usaha tani, normalisasi saluran irigasi dari aliran Sungai Cipancar, serta penguatan pos pelayanan terpadu (Posyandu) demi menunjang kenyamanan dan produktivitas warga.</p>',
                'content_en' => '<p>The Cigagade Village Government successfully held the Village Development Planning Meeting (Musrenbangdes) attended by the Village Head, Village Consultative Body (BPD), and community representatives.</p><p>Key priorities include farm road improvements, Cipancar river irrigation maintenance, and community healthcare facilities.</p>',
                'views' => 420,
            ],
            [
                'cat' => 'pemerintahan-pelayanan',
                'title' => 'Penyaluran Bantuan Langsung Tunai Dana Desa (BLT-DD) Berjalan Tertib dan Transparan di Aula Desa',
                'title_en' => 'Distribution of Direct Cash Assistance (BLT-DD) Conducted Orderly and Transparently at the Village Hall',
                'slug' => 'penyaluran-blt-dana-desa-cigagade',
                'slug_en' => 'distribution-of-direct-cash-assistance-cigagade',
                'excerpt' => 'Sebanyak puluhan Keluarga Penerima Manfaat (KPM) di Desa Cigagade menerima penyaluran BLT-DD dengan pendampingan aparat desa dan Babinsa.',
                'excerpt_en' => 'Dozens of Beneficiary Families in Cigagade Village received village fund cash assistance accompanied by village officials and local security officers.',
                'content' => '<p>Pemerintah Desa Cigagade menyalurkan Bantuan Langsung Tunai Dana Desa (BLT-DD) kepada Keluarga Penerima Manfaat (KPM) bertempat di Aula Kantor Desa Cigagade. Penyaluran ini merupakan wujud nyata kepedulian pemerintah dalam menjaga ketahanan ekonomi warga pra-sejahtera.</p><p>Kepala Desa menegaskan bahwa seluruh proses seleksi penerima manfaat dilakukan melalui musyawarah desa khusus (Musdessus) sehingga dipastikan tepat sasaran dan transparan.</p>',
                'content_en' => '<p>Cigagade Village Government disbursed Direct Cash Assistance from the Village Fund (BLT-DD) to eligible beneficiary families in the village hall with full transparency and verified criteria.</p>',
                'views' => 310,
            ],
            [
                'cat' => 'pertanian-ketahanan-pangan',
                'title' => 'Sinergi Petani Cigagade: Normalisasi Saluran Irigasi Cipancar Sambut Musim Tanam Rendeng',
                'title_en' => 'Synergy of Cigagade Farmers: Normalizing Cipancar Irrigation in Preparation for Planting Season',
                'slug' => 'normalisasi-irigasi-cipancar-petani-cigagade',
                'slug_en' => 'normalizing-cipancar-irrigation-cigagade-farmers',
                'excerpt' => 'Puluhan petani bersama warga bergotong royong membersihkan sedimentasi di sepanjang aliran sungai Cipancar untuk menjamin pasokan air sawah.',
                'excerpt_en' => 'Dozens of farmers and locals worked together to clean sedimentation along the Cipancar river stream to ensure sufficient irrigation for paddy fields.',
                'content' => '<p>Semangat gotong royong warga Desa Cigagade tercermin kuat dalam kegiatan normalisasi saluran irigasi tersier yang memanfaatkan debit air Sungai Cipancar. Kegiatan yang dikoordinatori oleh Gabungan Kelompok Tani (Gapoktan) bersama aparatur desa ini bertujuan mengoptimalkan pengairan pada ratusan hektar lahan persawahan produktif.</p>',
                'content_en' => '<p>The collaborative spirit of Cigagade residents is shown in the communal work cleaning irrigation canals sourced from the Cipancar river to support local agriculture.</p>',
                'views' => 285,
            ],
            [
                'cat' => 'ekonomi-umkm',
                'title' => 'Geliat UMKM Pangan Olahan Khas Cigagade Siap Perluas Pasar Kabupaten Garut',
                'title_en' => 'Cigagade Culinary MSMEs Ready to Expand Market Across Garut Regency',
                'slug' => 'geliat-umkm-pangan-khas-cigagade',
                'slug_en' => 'cigagade-culinary-msmes-expansion-garut',
                'excerpt' => 'Para pelaku usaha mikro di Desa Cigagade yang memproduksi rengginang, keripik, dan olahan hasil bumi mendapatkan pelatihan kemasan dan legalitas usaha.',
                'excerpt_en' => 'Micro-business actors in Cigagade producing traditional snacks and farm-produce items received packaging and business licensing training.',
                'content' => '<p>Desa Cigagade memiliki beragam potensi produk olahan makanan tradisional khas Sunda. Melalui kolaborasi antara BUMDes Gagade Mandiri dan Pemerintah Desa, para pelaku UMKM didorong untuk meningkatkan mutu kemasan, izin P-IRT, serta pemasaran digital agar mampu bersaing di pasar modern.</p>',
                'content_en' => '<p>Cigagade Village boasts traditional culinary potential. Through village government mentoring and BUMDes collaboration, local MSMEs are upgraded with modern packaging and digital branding.</p>',
                'views' => 195,
            ],

            // Kelembagaan (Ormawa mapping)
            [
                'cat' => 'kegiatan-ukm', // Karang Taruna
                'title' => 'Turnamen Sepak Bola Karang Taruna Karya Muda Cigagade Gelorakan Semangat Sportivitas Generasi Muda',
                'title_en' => 'Karya Muda Youth Organization Football Tournament Fosters Sportsmanship in Cigagade',
                'slug' => 'turnamen-sepak-bola-karang-taruna-cigagade',
                'slug_en' => 'youth-organization-football-tournament-cigagade',
                'excerpt' => 'Karang Taruna Desa Cigagade menggelar turnamen antar-kedusunan untuk memupuk persaudaraan dan menjaring bibit atlet muda berprestasi.',
                'excerpt_en' => 'The Cigagade Youth Organization held an inter-hamlet football tournament to foster brotherhood and discover young sports talents.',
                'content' => '<p>Pekan olahraga pemuda yang diinisiasi oleh Karang Taruna Desa Cigagade berlangsung meriah di lapangan desa. Kegiatan ini menjadi magnet hiburan positif bagi warga sekaligus mempererat silaturahmi antar-kampung di wilayah Desa Cigagade.</p>',
                'content_en' => '<p>The youth sports week initiated by Karang Taruna in Cigagade Village brought together hundreds of residents in an atmosphere of healthy competition and camaraderie.</p>',
                'views' => 380,
            ],
            [
                'cat' => 'prestasi-ukm', // TP-PKK
                'title' => 'TP-PKK Desa Cigagade Raih Penghargaan Pengelolaan Administrasi Posyandu Terbaik di Balubur Limbangan',
                'title_en' => 'Cigagade Village Family Welfare Movement (PKK) Wins Best Posyandu Administration Award',
                'slug' => 'tp-pkk-cigagade-raih-penghargaan-posyandu',
                'slug_en' => 'cigagade-pkk-wins-posyandu-award',
                'excerpt' => 'Dedikasi kader PKK Desa Cigagade dalam pendataan gizi anak dan penimbangan balita membuahkan apresiasi tingkat kecamatan.',
                'excerpt_en' => 'Dedication of Cigagade village healthcare volunteers in child nutrition tracking gained kecamatan-level appreciation.',
                'content' => '<p>Tim Penggerak Pemberdayaan dan Kesejahteraan Keluarga (TP-PKK) Desa Cigagade menorehkan prestasi membanggakan dengan meraih predikat terbaik dalam pembinaan administrasi posyandu dan pemantauan tumbuh kembang balita se-Kecamatan Balubur Limbangan.</p>',
                'content_en' => '<p>The Family Welfare Empowerment team (TP-PKK) of Cigagade Village achieved top recognition for outstanding posyandu management and child nutrition monitoring in the subdistrict.</p>',
                'views' => 260,
            ],
            [
                'cat' => 'kegiatan-himpunan', // BPD & LPMD
                'title' => 'BPD dan Pemerintah Desa Cigagade Tetapkan Peraturan Desa tentang Ketertiban Umum dan Lingkungan Hidup',
                'title_en' => 'BPD and Village Government Enact Village Regulation on Public Order and Environmental Protection',
                'slug' => 'bpd-tetapkan-perdes-ketertiban-lingkungan',
                'slug_en' => 'bpd-enacts-village-regulation-environmental-order',
                'excerpt' => 'Rapat paripurna BPD Desa Cigagade menyepakati Perdes baru demi menciptakan lingkungan yang tertib, bersih, dan asri.',
                'excerpt_en' => 'The plenary session of Cigagade Village Consultative Body agreed on a new local regulation for a clean and orderly environment.',
                'content' => '<p>Badan Permusyawaratan Desa (BPD) bersama Kepala Desa Cigagade secara resmi mengesahkan Peraturan Desa tentang Penyelenggaraan Ketertiban Umum, Pengelolaan Sampah, serta Pelestarian Lingkungan Hidup di wilayah desa.</p>',
                'content_en' => '<p>The Village Consultative Body (BPD) and Village Head of Cigagade formally ratified village regulations covering public order, waste disposal, and environmental conservation.</p>',
                'views' => 210,
            ],
            [
                'cat' => 'prestasi-himpunan', // Kelompok Tani & Linmas
                'title' => 'Kelompok Tani Desa Cigagade Catatkan Hasil Panen Padi Unggul 7,2 Ton per Hektar',
                'title_en' => 'Cigagade Farmers Group Achieves Superior Rice Harvest of 7.2 Tons per Hectare',
                'slug' => 'panen-padi-unggul-kelompok-tani-cigagade',
                'slug_en' => 'superior-rice-harvest-cigagade-farmers-group',
                'excerpt' => 'Penerapan pola tanam modern dan pemupukan berimbang berhasil meningkatkan produktivitas panen padi petani Cigagade.',
                'excerpt_en' => 'Modern farming methods and balanced fertilization boosted the rice productivity of Cigagade farmers.',
                'content' => '<p>Kelompok Tani Desa Cigagade berhasil membukukan produktivitas panen padi mencapai 7,2 ton gabah kering panen per hektar pada musim tanam kali ini. Hasil ini melampaui rata-rata wilayah kecamatan dan membuktikan potensi agraris Desa Cigagade.</p>',
                'content_en' => '<p>The Cigagade Village Farmers Group achieved an impressive yield of 7.2 tons per hectare, surpassing district averages and showcasing local agricultural prowess.</p>',
                'views' => 340,
            ],

            // Potensi Desa (Bengkel Ilmu mapping)
            [
                'cat' => 'karir-pengembangan-diri', // Pertanian & Irigasi
                'title' => 'Panduan Pola Tanam Terpadu dan Pemupukan Organik Ramah Lingkungan untuk Petani Desa',
                'title_en' => 'Integrated Planting and Eco-Friendly Organic Fertilization Guide for Village Farmers',
                'slug' => 'panduan-pola-tanam-organik-petani-cigagade',
                'slug_en' => 'integrated-organic-planting-guide-cigagade',
                'excerpt' => 'Artikel edukatif mengenai teknik pengolahan tanah sawah dan pemanfaatan kompos jerami untuk menekan biaya produksi pertanian.',
                'excerpt_en' => 'Educational article on soil management and compost utilization to minimize agricultural production costs.',
                'content' => '<p>Untuk menjaga kesuburan tanah di sepanjang daerah aliran sungai Cipancar, petani Desa Cigagade diajak menerapkan prinsip pertanian berkelanjutan dengan memadukan pupuk organik dan pengelolaan air yang terukur.</p>',
                'content_en' => '<p>Sustainable agricultural practices combining organic compost and water conservation to maintain soil fertility along the Cipancar basin.</p>',
                'views' => 175,
            ],
            [
                'cat' => 'riset-inovasi', // Inovasi & BUMDes
                'title' => 'Inovasi Digitalisasi Pelayanan Desa: Permohonan Surat Keterangan Warga Kini Lebih Cepat',
                'title_en' => 'Village Public Service Digitalization: Faster Online Administrative Certificate Requests',
                'slug' => 'digitalisasi-pelayanan-surat-desa-cigagade',
                'slug_en' => 'digitalization-village-certificate-services-cigagade',
                'excerpt' => 'Pelajari kemudahan mengurus Surat Keterangan Usaha (SKU), Domisili, dan Pengantar SKCK melalui website resmi Desa Cigagade.',
                'excerpt_en' => 'Learn how to easily request business certificates, residency proof, and police record letters online via Cigagade Village portal.',
                'content' => '<p>Kini warga Desa Cigagade tidak perlu menunggu lama untuk mengurus berkas permohonan surat keterangan. Melalui sistem pelayanan digital desa, warga dapat mengajukan data secara online dan mengambil surat yang telah ditandatangani di kantor desa.</p>',
                'content_en' => '<p>Residents of Cigagade Village can now enjoy seamless online certificate applications, saving time and simplifying administrative procedures.</p>',
                'views' => 290,
            ],
            [
                'cat' => 'hiburan', // Seni, Budaya & Wisata
                'title' => 'Menelusuri Sejarah dan Wisata Religi Makam Kiai Gede Sunan Cibalampu di Desa Cigagade',
                'title_en' => 'Exploring History and Spiritual Tourism of Kiai Gede Sunan Cibalampu in Cigagade',
                'slug' => 'sejarah-wisata-religi-sunan-cibalampu-cigagade',
                'slug_en' => 'spiritual-tourism-history-sunan-cibalampu-cigagade',
                'excerpt' => 'Kisah sejarah lokal dan pesona ziarah makam Kiai Gede di kawasan Cibalampu yang menjadi bagian penting dari warisan budaya desa.',
                'excerpt_en' => 'The local historical heritage and spiritual attraction of Kiai Gede tomb in Cibalampu, an integral part of village culture.',
                'content' => '<p>Desa Cigagade menyimpan warisan sejarah yang mendalam, salah satunya adalah situs makam sesepuh Kiai Gede di kawasan perbukitan Sunan Cibalampu yang kerap dikunjungi masyarakat untuk berziarah dan merenungi sejarah penyebaran Islam di wilayah Limbangan Garut.</p>',
                'content_en' => '<p>Cigagade Village preserves a profound cultural heritage, including the tomb of Kiai Gede on Mount Sunan Cibalampu, frequently visited by pilgrims and history enthusiasts.</p>',
                'views' => 450,
            ],
            [
                'cat' => 'institusional', // Layanan & Kesehatan
                'title' => 'Pola Hidup Bersih dan Sehat (PHBS): Kiat Menjaga Kesehatan Keluarga di Lingkungan Perdesaan',
                'title_en' => 'Clean and Healthy Lifestyle (PHBS): Tips for Maintaining Family Health in Rural Communities',
                'slug' => 'pola-hidup-bersih-sehat-phbs-desa-cigagade',
                'slug_en' => 'clean-healthy-lifestyle-phbs-cigagade-village',
                'excerpt' => 'Edukasi kesehatan mengenai air bersih, jamban sehat, pengelolaan sampah rumah tangga, serta pencegahan DBD.',
                'excerpt_en' => 'Health education on clean water, household sanitation, and community disease prevention.',
                'content' => '<p>Pemerintah Desa Cigagade bekerjasama dengan tenaga kesehatan Puskesmas Balubur Limbangan terus mengedukasi warga mengenai pentingnya sanitasi lingkungan, konsumsi air bersih, dan pembuangan sampah yang tepat demi menjaga kesehatan bersama.</p>',
                'content_en' => '<p>Health education regarding clean water, household sanitation, and vector-borne disease prevention conducted collaboratively with local clinics.</p>',
                'views' => 160,
            ],

            // Prestasi (Category name: 'Prestasi')
            [
                'cat' => 'prestasi',
                'title' => 'Desa Cigagade Raih Apresiasi Tertib Administrasi dan Akuntabilitas Dana Desa Terbaik se-Kecamatan',
                'title_en' => 'Cigagade Village Receives Best Village Fund Accountability and Administration Award',
                'slug' => 'prestasi-tertib-administrasi-dana-desa-cigagade',
                'slug_en' => 'village-fund-accountability-award-cigagade',
                'excerpt' => 'Pemerintah Kabupaten Garut melalui pihak Kecamatan Balubur Limbangan memberikan apresiasi atas kecepatan dan kepatuhan pelaporan keuangan Desa Cigagade.',
                'excerpt_en' => 'Garut Regency Government through the subdistrict recognized Cigagade Village for prompt and accurate financial reporting.',
                'content' => '<p>Prestasi membanggakan kembali diraih Pemerintah Desa Cigagade atas dedikasi dan komitmen dalam pengelolaan Anggaran Pendapatan dan Belanja Desa (APBDes) yang transparan, akuntabel, serta tepat waktu dalam pelaporan pertanggungjawaban.</p>',
                'content_en' => '<p>Cigagade Village was honored for exemplary transparency and timeliness in village budget management and public accountability.</p>',
                'views' => 520,
            ],
            [
                'cat' => 'prestasi',
                'title' => 'Juara 2 Posyandu Percontohan dan Inovasi Penanganan Gizi Balita Tingkat Balubur Limbangan',
                'title_en' => 'Second Place for Model Posyandu and Child Nutrition Innovation in Balubur Limbangan',
                'slug' => 'juara-posyandu-percontohan-cigagade',
                'slug_en' => 'model-posyandu-runner-up-cigagade',
                'excerpt' => 'Kerja keras para kader posyandu dan bidan desa dalam menurunkan angka stunting berhasil membawa penghargaan membanggakan.',
                'excerpt_en' => 'Tireless efforts by community health cadres and village midwives in stunting prevention earned a prestigious accolade.',
                'content' => '<p>Posyandu Mawar Desa Cigagade berhasil merebut Juara 2 dalam ajang apresiasi posyandu teladan tingkat Kecamatan Balubur Limbangan berkat inovasi program pendampingan ibu hamil dan pemberian makanan tambahan berbahan pangan lokal.</p>',
                'content_en' => '<p>Cigagade Village healthcare center won second place in the subdistrict model posyandu evaluation thanks to innovative nutrition programs.</p>',
                'views' => 310,
            ],

            // Pengumuman (Category name: 'Pengumuman')
            [
                'cat' => 'pengumuman',
                'title' => 'Jadwal Pelayanan Pembuatan KTP Elektronik, Kartu Keluarga, dan Akta Kelahiran di Kantor Desa Cigagade',
                'title_en' => 'Schedule for Electronic ID, Family Card, and Birth Certificate Services at Cigagade Village Office',
                'slug' => 'jadwal-pelayanan-ktp-kk-desa-cigagade',
                'slug_en' => 'id-card-family-certificate-services-cigagade',
                'excerpt' => 'Masyarakat Desa Cigagade dapat memanfaatkan jadwal pelayanan administrasi kependudukan setiap hari kerja Senin hingga Jumat pukul 08.00 - 15.00 WIB.',
                'excerpt_en' => 'Cigagade residents can access civil registry and identity documentation services on weekdays from 08:00 to 15:00 WIB.',
                'content' => '<p>Diberitahukan kepada seluruh warga Desa Cigagade bahwa pelayanan administrasi kependudukan (perekaman KTP-el, pengurusan Kartu Keluarga, Akta Kelahiran, dan Surat Pindah) dibuka setiap hari kerja di Kantor Desa Cigagade. Mohon membawa dokumen persyaratan asli dan fotokopi lengkap.</p>',
                'content_en' => '<p>All residents are notified that civil documentation services are available every weekday at the Village Office. Please bring all necessary original and copied documents.</p>',
                'views' => 640,
            ],
            [
                'cat' => 'pengumuman',
                'title' => 'Pemberitahuan Pelunasan Pajak Bumi dan Bangunan Perdesaan (PBB-P2) Desa Cigagade Tahun Anggaran Berjalan',
                'title_en' => 'Notification on Land and Building Tax (PBB-P2) Settlement for Cigagade Village',
                'slug' => 'pemberitahuan-pelunasan-pbb-desa-cigagade',
                'slug_en' => 'land-building-tax-settlement-cigagade',
                'excerpt' => 'Kolektor desa siap melayani pembayaran PBB-P2 warga di tiap dusun atau langsung melalui loket Kantor Desa Cigagade.',
                'excerpt_en' => 'Village tax officers are ready to assist residents with land and building tax payments in each hamlet or directly at the village counter.',
                'content' => '<p>Pemerintah Desa Cigagade menghimbau kepada seluruh Wajib Pajak untuk melakukan pembayaran Pajak Bumi dan Bangunan (PBB-P2) sebelum tanggal jatuh tempo. Pembayaran dapat dilakukan melalui petugas kolektor dusun setempat atau loket pelayanan kantor desa.</p>',
                'content_en' => '<p>Cigagade Village Government urges all taxpayers to settle land and building taxes before the due date through local hamlet collectors or the village service counter.</p>',
                'views' => 480,
            ],
            [
                'cat' => 'pengumuman',
                'title' => 'Jadwal Rutin Posyandu Balita dan Posbindu Lansia Bulan Ini di Seluruh Wilayah RW Desa Cigagade',
                'title_en' => 'Monthly Schedule for Toddler and Elderly Health Clinics Across Cigagade Village',
                'slug' => 'jadwal-rutin-posyandu-posbindu-cigagade',
                'slug_en' => 'monthly-health-clinic-schedule-cigagade',
                'excerpt' => 'Simak jadwal penimbangan balita, imunisasi dasar, serta pemeriksaan tensi dan gula darah gratis bagi lansia.',
                'excerpt_en' => 'Check the schedule for toddler weighing, mandatory vaccinations, and free health checkups for the elderly.',
                'content' => '<p>Pemerintah Desa Cigagade bersama Bidan Desa dan Kader PKK mengumumkan jadwal kegiatan Posyandu Balita dan Posbindu Lansia serentak di Pos RW 01 sampai dengan RW 08. Seluruh masyarakat diimbau membawa buku KIA dan KMS balita.</p>',
                'content_en' => '<p>Cigagade Village announces this month schedule for mother-and-child healthcare clinics across RW 01 through RW 08.</p>',
                'views' => 390,
            ],
        ];

        foreach ($samplePosts as $p) {
            $catId = $catMap[$p['cat']] ?? null;
            if (!$catId) continue;

            Post::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'category_id'  => $catId,
                    'user_id'      => $admin->id,
                    'title'        => $p['title'],
                    'title_en'     => $p['title_en'] ?? $p['title'],
                    'slug_en'      => $p['slug_en'] ?? $p['slug'],
                    'excerpt'      => $p['excerpt'],
                    'excerpt_en'   => $p['excerpt_en'] ?? $p['excerpt'],
                    'content'      => $p['content'],
                    'content_en'   => $p['content_en'] ?? $p['content'],
                    'image'        => null,
                    'views'        => $p['views'] ?? 100,
                    'published_at' => now()->subDays(rand(1, 20)),
                ]
            );
        }

        // 8. Videos
        $sampleVideos = [
            [
                'title' => 'Profil Pemerintahan dan Potensi Alam Desa Cigagade Limbangan Garut',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Dokumentasi Semarak HUT RI dan Gotong Royong Warga Cigagade',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'is_featured' => false,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Mengenal Potensi Pertanian dan Aliran Sungai Cipancar Cigagade',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'is_featured' => false,
                'published_at' => now()->subDays(25),
            ],
        ];

        foreach ($sampleVideos as $v) {
            Video::updateOrCreate(
                ['title' => $v['title']],
                [
                    'youtube_url' => $v['youtube_url'],
                    'is_featured' => $v['is_featured'],
                    'published_at' => $v['published_at'],
                ]
            );
        }
    }
}
