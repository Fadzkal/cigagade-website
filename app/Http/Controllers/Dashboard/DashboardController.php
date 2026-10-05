<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Ministry;
use App\Models\Partner;
use App\Models\Umkm;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ─── Global Stats ───────────────────────────────────────────────
        $totalPosts      = Post::count();
        $totalViews      = Post::sum('views');
        $totalCategories = Category::count();
        $totalGalleries  = Gallery::count();
        $totalMinistries = Ministry::count();
        $totalPartners   = Partner::count();
        $totalUmkm       = Umkm::count();

        // ─── Top 10 Most Popular Posts ──────────────────────────────────
        $popularPosts = Post::with('category')
            ->orderByDesc('views')
            ->take(10)
            ->get();

        // ─── Latest 5 Posts ─────────────────────────────────────────────
        $latestPosts = Post::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // ─── Posts per Category (for chart) ─────────────────────────────
        $postsByCategory = Category::withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->get();

        // ─── Views per Category (for chart) ─────────────────────────────
        $viewsByCategory = Category::select('categories.name', DB::raw('SUM(posts.views) as total_views'))
            ->join('posts', 'posts.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_views')
            ->get();

        // ─── Monthly post count (last 6 months) ─────────────────────────
        $monthlyPosts = Post::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('dashboard', compact(
            'totalPosts',
            'totalViews',
            'totalCategories',
            'totalGalleries',
            'totalMinistries',
            'totalPartners',
            'totalUmkm',
            'popularPosts',
            'latestPosts',
            'postsByCategory',
            'viewsByCategory',
            'monthlyPosts'
        ));
    }
}
