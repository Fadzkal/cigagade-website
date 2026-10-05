<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VisitorService
{
    /**
     * Record a visit if it has not been recorded today for this visitor.
     */
    public function recordVisit(Request $request): bool
    {
        try {
            $ip = $request->ip() ?: '127.0.0.1';
            $userAgent = $request->userAgent() ?: 'Unknown';
            $sessionId = session()->getId();
            $today = Carbon::today()->toDateString();

            // Hash based on IP + User Agent + Date for unique daily visitor
            $hash = hash('sha256', $ip . '|' . substr($userAgent, 0, 100) . '|' . $today);
            $cacheKey = 'visitor_seen_' . $hash;

            if (Cache::has($cacheKey)) {
                return false;
            }

            // Check database to ensure no duplicate for this day
            $exists = VisitorLog::where('visit_date', $today)
                ->where('ip_hash', $hash)
                ->exists();

            if (!$exists) {
                VisitorLog::create([
                    'ip_address' => $ip,
                    'ip_hash' => $hash,
                    'user_agent' => substr($userAgent, 0, 255),
                    'session_id' => $sessionId,
                    'page_url' => substr($request->fullUrl(), 0, 255),
                    'visit_date' => $today,
                ]);

                // Clear cached stats so real-time counters immediately refresh
                Cache::forget('visitor_stats_today_count');
            }

            // Mark seen for the rest of today
            Cache::put($cacheKey, 1, Carbon::now()->endOfDay());

            return true;
        } catch (\Throwable $e) {
            Log::warning('VisitorService recordVisit error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get aggregated visitor statistics.
     */
    public function getStats(): array
    {
        try {
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();

            // Start of this week (Sunday) and end of this week (Saturday)
            $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
            $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);

            // Last week (Sunday to Saturday of previous week)
            $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY);
            $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::SATURDAY);

            // Current month and previous month
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

            // Today's count (real-time, with short cache)
            $todayCount = VisitorLog::where('visit_date', $today->toDateString())->count();

            // Yesterday's count (cached for 1 hour since yesterday is immutable)
            $yesterdayCount = Cache::remember('visitor_stats_yesterday', 3600, function () use ($yesterday) {
                return VisitorLog::where('visit_date', $yesterday->toDateString())->count();
            });

            // This week count
            $thisWeekCount = VisitorLog::whereBetween('visit_date', [
                $startOfWeek->toDateString(),
                $today->toDateString(),
            ])->count();

            // Last week count
            $lastWeekCount = Cache::remember('visitor_stats_last_week', 3600, function () use ($startOfLastWeek, $endOfLastWeek) {
                return VisitorLog::whereBetween('visit_date', [
                    $startOfLastWeek->toDateString(),
                    $endOfLastWeek->toDateString(),
                ])->count();
            });

            // This month count
            $thisMonthCount = VisitorLog::whereBetween('visit_date', [
                $startOfMonth->toDateString(),
                $today->toDateString(),
            ])->count();

            // Last month count
            $lastMonthCount = Cache::remember('visitor_stats_last_month', 3600, function () use ($startOfLastMonth, $endOfLastMonth) {
                return VisitorLog::whereBetween('visit_date', [
                    $startOfLastMonth->toDateString(),
                    $endOfLastMonth->toDateString(),
                ])->count();
            });

            // Base historical offset from settings
            $baseOffset = (int) (Setting::where('key', 'visitor_base_offset')->value('value') ?? 0);
            $totalCount = VisitorLog::count() + $baseOffset;

            return [
                'today' => $todayCount,
                'yesterday' => $yesterdayCount,
                'this_week' => $thisWeekCount,
                'last_week' => $lastWeekCount,
                'this_month' => $thisMonthCount,
                'last_month' => $lastMonthCount,
                'total' => $totalCount,
            ];
        } catch (\Throwable $e) {
            Log::warning('VisitorService getStats error: ' . $e->getMessage());
            return [
                'today' => 1,
                'yesterday' => 0,
                'this_week' => 1,
                'last_week' => 0,
                'this_month' => 1,
                'last_month' => 0,
                'total' => 1,
            ];
        }
    }
}
