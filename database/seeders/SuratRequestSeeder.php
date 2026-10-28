<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratRequest;

class SuratRequestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SKU (Surat Keterangan Usaha) - Sesuai Template PDF Hal 1
        SuratRequest::firstOrCreate(
            ['tracking_code' => 'SRT-202610-001'],
            [
                'jenis_surat' => 'sku',
                'nomor_surat' => '517/ 018 /2011-DS/X/2026',
                'status' => 'selesai',
                'tanggal_surat' => '2026-10-26',
                'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I.',
                'jabatan_kades' => 'Kepala Desa Cigagade',
                'nama_lengkap' => 'ASEP KURNIAWAN',
                'nik' => '3205011211890001',
                'no_kk' => '3205011211890001',
                'no_telepon' => '081234567890',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '1989-11-12',
                'jenis_kelamin' => 'Laki-laki',
                'warga_negara' => 'Indonesia',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Buruh Harian Lepas',
                'agama' => 'Islam',
                'alamat' => 'KP. Ranca Paku',
                'rt' => '001',
                'rw' => '006',
                'desa' => 'Cigagade',
                'kecamatan' => 'Balubur Limbangan',
                'kabupaten' => 'Garut',
                'keperluan' => 'Persyaratan Credit BANK',
                'data_spesifik' => [
                    'nama_usaha' => 'Usaha Kuliner (Bakso Tahu & Cuangki)',
                    'alamat_usaha' => 'Kp. Krajan RT 14 RW 02, Desa Sukadami, Wanayasa, Purwakarta',
                ],
            ]
        );

        // 2. SKBB (Surat Keterangan Berkelakuan Baik) - Sesuai Template PDF Hal 2
        SuratRequest::firstOrCreate(
            ['tracking_code' => 'SRT-202610-002'],
            [
                'jenis_surat' => 'skbb',
                'nomor_surat' => '331/ 025 /2011-DS/X/2026',
                'status' => 'selesai',
                'tanggal_surat' => '2026-10-26',
                'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I.',
                'jabatan_kades' => 'Kepala Desa Cigagade',
                'nama_lengkap' => 'RIDWAN NURDIN',
                'nik' => '3205011508920002',
                'no_telepon' => '082123456781',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '1992-08-15',
                'jenis_kelamin' => 'Laki-laki',
                'warga_negara' => 'Indonesia',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Buruh Harian Lepas',
                'agama' => 'Islam',
                'alamat' => 'KP. Ranca Paku',
                'rt' => '001',
                'rw' => '006',
                'desa' => 'Cigagade',
                'kecamatan' => 'Balubur Limbangan',
                'kabupaten' => 'Garut',
                'keperluan' => 'Kelengkapan Credit Bank',
                'data_spesifik' => [],
            ]
        );

        // 3. SKD (Surat Keterangan Domisili) - Sesuai Template PDF Hal 3
        SuratRequest::firstOrCreate(
            ['tracking_code' => 'SRT-202610-003'],
            [
                'jenis_surat' => 'skd',
                'nomor_surat' => '474.4/ 042 /DS-2011/III/2022',
                'status' => 'selesai',
                'tanggal_surat' => '2022-03-21',
                'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I',
                'jabatan_kades' => 'Kepala Desa Cigagade',
                'nama_lengkap' => 'SITI NURJANAH',
                'nik' => '3205014505700003',
                'no_telepon' => '085234567892',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '1970-05-05',
                'jenis_kelamin' => 'Perempuan',
                'warga_negara' => 'Indonesia',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Mengurus Rumah Tangga',
                'agama' => 'Islam',
                'alamat' => 'Tonjong Kulon',
                'rt' => '002',
                'rw' => '002',
                'desa' => 'Cigagade',
                'kecamatan' => 'Balubur Limbangan',
                'kabupaten' => 'Garut',
                'keperluan' => 'Keterangan Domisili Tempat Tinggal',
                'data_spesifik' => [],
            ]
        );

        // 4. SKTM (Surat Keterangan Tidak Mampu) - Sesuai Template PDF Hal 4
        SuratRequest::firstOrCreate(
            ['tracking_code' => 'SRT-202610-004'],
            [
                'jenis_surat' => 'sktm',
                'nomor_surat' => '460 / 011 /DS-2011/VII/2026',
                'status' => 'diproses',
                'tanggal_surat' => '2023-04-19',
                'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I.',
                'jabatan_kades' => 'Kepala Desa Cigagade',
                'nama_lengkap' => 'NENG SALMA',
                'nik' => '3205016203040004',
                'no_telepon' => '087812345673',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '2004-03-22',
                'jenis_kelamin' => 'Perempuan',
                'warga_negara' => 'Indonesia',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Pelajar/Mahasiswa',
                'agama' => 'Islam',
                'alamat' => 'KP. Bantar Teureup',
                'rt' => '001',
                'rw' => '004',
                'desa' => 'Cigagade',
                'kecamatan' => 'BL.Limbangan',
                'kabupaten' => 'Garut',
                'keperluan' => 'Keringanan Biaya di PUSKESMAS',
                'data_spesifik' => [],
            ]
        );

        // 5. SKM (Surat Keterangan Menikah) - Sesuai Template PDF Hal 5
        SuratRequest::firstOrCreate(
            ['tracking_code' => 'SRT-202610-005'],
            [
                'jenis_surat' => 'skm',
                'nomor_surat' => '474.2/ 007 /2011-DS /VI/2026',
                'status' => 'selesai',
                'tanggal_surat' => '2026-02-20',
                'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I',
                'jabatan_kades' => 'Kepala Desa Cigagade',
                'nama_lengkap' => 'JAKA',
                'nik' => '3205011111910005',
                'no_telepon' => '089612345674',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '1991-11-11',
                'jenis_kelamin' => 'Laki-laki',
                'warga_negara' => 'Indonesia',
                'status_perkawinan' => 'Jejaka',
                'pekerjaan' => 'Buruh Harian Lepas',
                'agama' => 'Islam',
                'alamat' => 'KP. Rancasaat RT. 001 RW. 009 Desa Cigagade Kecamatan Bl. Limbangan Kabupaten Garut',
                'rt' => '001',
                'rw' => '009',
                'desa' => 'Cigagade',
                'kecamatan' => 'Bl. Limbangan',
                'kabupaten' => 'Garut',
                'keperluan' => 'Persyaratan Isbat Nikah',
                'data_spesifik' => [
                    'suami_nama' => 'JAKA',
                    'suami_bin' => 'TOSIN',
                    'suami_jenis_kelamin' => 'Laki-aki',
                    'suami_ttl' => 'Garut, 11 November 1991',
                    'suami_agama' => 'Islam',
                    'suami_status_perkawinan' => 'Jejaka',
                    'suami_warga_negara' => 'Indonesia',
                    'suami_pekerjaan' => 'Buruh Harian Lepas',
                    'suami_alamat' => 'KP. Rancasaat RT. 001 RW. 009 Desa Cigagade Kecamatan Bl. Limbangan Kabupaten Garut',

                    'istri_nama' => 'DINI SITI ROHANI',
                    'istri_binti' => 'ELAN HAMBALI',
                    'istri_jenis_kelamin' => 'Perempuan',
                    'istri_ttl' => 'Garut, 01 Juli 1979',
                    'istri_agama' => 'Islam',
                    'istri_status_perkawinan' => 'Cerai Hidup',
                    'istri_warga_negara' => 'Indonesia',
                    'istri_pekerjaan' => 'Mengurus Rumah Tangga',
                    'istri_alamat' => 'Rancapaku RT. 001 RW. 006 Desa Cigagade Kecamatan Bl. Limbangan Kabupaten Garut',

                    'tanggal_pernikahan' => '25 Oktober 2021',
                    'kua_kecamatan' => 'KUA Bl. Limbangan',
                ],
            ]
        );

        // 6. SKBM (Surat Keterangan Belum Menikah) - Sesuai Template PDF Hal 6
        SuratRequest::firstOrCreate(
            ['tracking_code' => 'SRT-202610-006'],
            [
                'jenis_surat' => 'skbm',
                'nomor_surat' => '400/ 088 /2011-DS/X/2026',
                'status' => 'pending',
                'tanggal_surat' => '2026-10-20',
                'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I.',
                'jabatan_kades' => 'Kepala Desa Cigagade',
                'nama_lengkap' => 'FAJAR ILHAM',
                'nik' => '3205012404020006',
                'no_telepon' => '083812345675',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '2002-04-24',
                'jenis_kelamin' => 'Laki-laki',
                'warga_negara' => 'Indonesia',
                'status_perkawinan' => 'Belum Kawin',
                'pekerjaan' => 'Pelajar/Mahasiswa',
                'agama' => 'Islam',
                'alamat' => 'KP. Tengger',
                'rt' => '001',
                'rw' => '010',
                'desa' => 'Cigagade',
                'kecamatan' => 'Balubur Limbangan',
                'kabupaten' => 'Garut',
                'keperluan' => 'Persyaratan Melamar Pekerjaan',
                'data_spesifik' => [
                    'pernyataan_rt' => '01',
                    'pernyataan_rw' => '10',
                ],
            ]
        );

        // 7. SKP (Surat Keterangan Penghasilan) - Sesuai Template PDF Hal 7
        SuratRequest::firstOrCreate(
            ['tracking_code' => 'SRT-202610-007'],
            [
                'jenis_surat' => 'skp',
                'nomor_surat' => '400/ 053 /2011-DS/VI/2026',
                'status' => 'selesai',
                'tanggal_surat' => '2026-06-15',
                'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I.',
                'jabatan_kades' => 'Kepala Desa Cigagade',
                'nama_lengkap' => 'DEDE SUHENDAR',
                'nik' => '3205010906750007',
                'no_telepon' => '081312345676',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '1975-06-09',
                'jenis_kelamin' => 'Laki-laki',
                'warga_negara' => 'Indonesia',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Buruh Harian Lepas',
                'agama' => 'Islam',
                'alamat' => 'KP. Sukadana',
                'rt' => '001',
                'rw' => '001',
                'desa' => 'Cigagade',
                'kecamatan' => 'Balubur Limbangan',
                'kabupaten' => 'Garut',
                'keperluan' => 'Untuk Persyaratan Melanjutkan Pendidikan Ke perguruan Tinggi An. PUTRI NAYLA ALYA',
                'data_spesifik' => [
                    'pernyataan_rt' => '01',
                    'pernyataan_rw' => '01',
                    'penghasilan_perbulan' => 500000,
                    'penghasilan_terbilang' => 'Lima ratus ribu rupiah',
                ],
            ]
        );
    }
}
