<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Umkm;
use App\Models\Gallery;
use App\Models\HeroSlide;
use App\Models\LandscapeBanner;
use App\Models\Ministry;
use App\Models\Setting;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML Sitemap with Google Images extensions
     * Official specification: http://www.google.com/schemas/sitemap-image/1.1
     */
    public function index(): Response
    {
        $posts = Post::with('category')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->latest()
            ->get();

        $umkms = Umkm::where('is_active', true)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->latest()
            ->get();

        $galleries = Gallery::whereNotNull('image')
            ->where('image', '!=', '')
            ->latest()
            ->get();

        $banners = LandscapeBanner::where('is_active', true)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->get();

        $heroSlides = HeroSlide::where('is_active', true)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->get();

        $ministries = Ministry::whereNotNull('image')
            ->where('image', '!=', '')
            ->get();

        $settings = Setting::pluck('value', 'key');

        $content = view('sitemap', compact(
            'posts',
            'umkms',
            'galleries',
            'banners',
            'heroSlides',
            'ministries',
            'settings'
        ))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml; charset=utf-8')
            ->header('X-Robots-Tag', 'noindex, follow');
    }
}
