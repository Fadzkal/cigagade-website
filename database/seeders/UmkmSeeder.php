<?php

namespace Database\Seeders;

use App\Models\Umkm;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Kopi Robusta Lereng Cigagade',
                'category' => 'Makanan & Minuman',
                'price' => 45000,
                'unit' => '250gr',
                'seller_name' => 'Kang Dudung (Kelompok Tani Harapan Jaya)',
                'phone' => '081223344556',
                'address' => 'Dusun Cibalampu RT 01/RW 03, Desa Cigagade',
                'description' => "Kopi robusta pilihan dipetik merah dari kebun lereng perbukitan Desa Cigagade dengan ketinggian sejuk. Diproses secara natural dan dipanggang medium-dark, menghasilkan cita rasa aroma cokelat kacang yang mantap, tebal, dan rendah asam. Sangat cocok diseduh tubruk maupun filter.",
                'image' => 'umkm/kopi-robusta.jpg',
                'is_active' => true,
                'views' => 42,
            ],
            [
                'name' => 'Keripik Singkong Pedas Gurih Cigagade',
                'category' => 'Makanan & Minuman',
                'price' => 18000,
                'unit' => 'bungkus',
                'seller_name' => 'Ibu Enok Rosidah',
                'phone' => '085798765432',
                'address' => 'Dusun Cigagade Hilir RT 02/RW 01, Desa Cigagade',
                'description' => "Camilan khas warga Cigagade dibuat dari singkong mentega segar hasil panen kebun lokal. Diiris tipis lalu digoreng garing renyah dengan baluran cabai rawit segar, bawang putih, dan aroma daun jeruk purut asli tanpa pengawet. Tersedia level pedas sedang dan ekstra pedas.",
                'image' => 'umkm/keripik-singkong.jpg',
                'is_active' => true,
                'views' => 65,
            ],
            [
                'name' => 'Gula Aren Batok Murni Cigagade',
                'category' => 'Makanan & Minuman',
                'price' => 32000,
                'unit' => 'kg',
                'seller_name' => 'Mang Ujang Saepudin',
                'phone' => '081394123456',
                'address' => 'Dusun Pasir Pari RT 03/RW 02, Desa Cigagade',
                'description' => "Gula aren asli disadap langsung dari pohon enau perbukitan Cigagade setiap pagi. Dimasak secara tradisional di atas tungku kayu bakar menghasilkan wangi karamel alami yang kuat dan rasa manis legit tidak enek. Sangat pas untuk pemanis kopi, teh, olahan kue basah, atau kolak.",
                'image' => 'umkm/gula-aren.jpg',
                'is_active' => true,
                'views' => 29,
            ],
            [
                'name' => 'Kerajinan Anyaman Bambu Tradisional',
                'category' => 'Kerajinan Tangan',
                'price' => 65000,
                'unit' => 'set',
                'seller_name' => 'Pak Tatang (Sentra Anyaman Bambu)',
                'phone' => '082115678901',
                'address' => 'Dusun Cigagade Girang RT 04/RW 02, Desa Cigagade',
                'description' => "Satu set wadah anyaman bambu handmade terdiri dari besek serbaguna, boboko tempat nasi, dan wadah saji ramah lingkungan. Dibuat dari bambu tali pilihan yang diolah secara teliti, dihaluskan, dan diawetkan secara alami sehingga bebas jamur dan tahan bertahun-tahun.",
                'image' => 'umkm/anyaman-bambu.png',
                'is_active' => true,
                'views' => 18,
            ],
            [
                'name' => 'Beras Organik Terasering Cigagade',
                'category' => 'Pertanian & Perkebunan',
                'price' => 78000,
                'unit' => '5 kg',
                'seller_name' => 'Gapoktan Mekar Mukti Cigagade',
                'phone' => '087823456789',
                'address' => 'Kompleks Lumbung Pangan Dusun II, Desa Cigagade',
                'description' => "Beras pulen alami tanpa pestisida kimia yang ditanam di persawahan terasering subur Cigagade dengan sistem irigasi mata air pegunungan. Dipanen dan digiling langsung saat ada pesanan agar kesegaran dan aroma pulen alaminya tetap terjaga sempurna.",
                'image' => 'umkm/beras-organik.png',
                'is_active' => true,
                'views' => 37,
            ],
        ];

        foreach ($products as $data) {
            Umkm::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
