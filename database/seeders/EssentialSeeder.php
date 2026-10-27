<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seed ESENSIAL — aman untuk produksi & idempoten (dipanggil entrypoint tiap container start).
 * Hanya kategori yang slug-nya dirujuk kode + 1 superadmin dari env (ADMIN_EMAIL/ADMIN_PASSWORD).
 * Data contoh (berita, akun RW, dsb.) ada di DatabaseSeeder dan HANYA untuk mode demo.
 */
class EssentialSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kabar Desa',                   'slug' => 'kabar-desa'],
            ['name' => 'Pemerintahan & Pelayanan',     'slug' => 'pemerintahan-pelayanan'],
            ['name' => 'Pembangunan & Infrastruktur',  'slug' => 'pembangunan-infrastruktur'],
            ['name' => 'Sosial & Kemasyarakatan',      'slug' => 'sosial-kemasyarakatan'],
            ['name' => 'Ekonomi & UMKM',               'slug' => 'ekonomi-umkm'],
            ['name' => 'Pertanian & Ketahanan Pangan', 'slug' => 'pertanian-ketahanan-pangan'],
            ['name' => 'Prestasi',                     'slug' => 'prestasi'],
            ['name' => 'Pengumuman',                   'slug' => 'pengumuman'],
            ['name' => 'Karang Taruna',                'slug' => 'kegiatan-ukm'],
            ['name' => 'TP-PKK Desa',                  'slug' => 'prestasi-ukm'],
            ['name' => 'BPD & LPMD',                   'slug' => 'kegiatan-himpunan'],
            ['name' => 'Kelompok Tani & Linmas',       'slug' => 'prestasi-himpunan'],
            ['name' => 'Pertanian & Irigasi',          'slug' => 'karir-pengembangan-diri'],
            ['name' => 'Inovasi & BUMDes',             'slug' => 'riset-inovasi'],
            ['name' => 'Seni, Budaya & Wisata',        'slug' => 'hiburan'],
            ['name' => 'Layanan & Kesehatan Warga',    'slug' => 'institusional'],
        ];

        // firstOrCreate: nama kategori yang sudah diubah admin tidak ditimpa.
        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], ['name' => $category['name']]);
        }

        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command->warn('ADMIN_EMAIL/ADMIN_PASSWORD kosong — akun admin tidak dibuat.');
            return;
        }

        if (str_starts_with($password, 'GANTI')) {
            $this->command->warn('ADMIN_PASSWORD masih placeholder — segera ganti di file env!');
        }

        // Hanya dibuat sekali; password yang sudah diganti lewat dashboard tidak ditimpa.
        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name'     => env('ADMIN_NAME', 'Administrator Desa Cigagade'),
                'password' => Hash::make($password),
                'role'     => 'superadmin',
            ]
        );

        // email_verified_at tidak ada di $fillable, padahal rute dashboard memakai middleware 'verified'.
        if (! $admin->email_verified_at) {
            $admin->forceFill(['email_verified_at' => now()])->save();
        }
    }
}
