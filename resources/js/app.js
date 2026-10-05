import './bootstrap';

// ===================================
// TAMBAHKAN BLOK KODE INI
// ===================================
import Splide from '@splidejs/splide';

// Inisialisasi Splide setelah halaman dimuat
// Inisialisasi Splide (tanpa DOMContentLoaded karena type="module" sudah deferred)
var splides = document.querySelectorAll('.splide');
window.heroSplide = null;

if (splides.length) {
    // Loop setiap elemen dan inisialisasi
    for (var i = 0; i < splides.length; i++) {

        // Ambil data-options dari atribut HTML
        var options = {};
        if (splides[i].dataset.options) {
            options = JSON.parse(splides[i].dataset.options);
        }

        var instance = new Splide(splides[i], options).mount();

        // Simpan hero slider ke variabel global
        if (splides[i].id === 'hero-slider') {
            window.heroSplide = instance;
        }
    }
}
// ===================================
// AKHIR BLOK KODE
// ===================================
