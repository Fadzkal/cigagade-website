@props(['stats' => null])

@php
    if (!isset($stats) || empty($stats)) {
        if (isset($visitorStats) && !empty($visitorStats)) {
            $stats = $visitorStats;
        } else {
            try {
                $stats = app(\App\Services\VisitorService::class)->getStats();
            } catch (\Throwable $e) {
                $stats = [
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
@endphp

<div id="visitor-widget"
     x-data="{
        open: false,
        stats: @js($stats),
        init() {
            // Otomatis sinkronkan statistik terbaru saat halaman dimuat
            this.refreshStats();
        },
        format(num) {
            return (num || 0).toLocaleString('id-ID');
        },
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.refreshStats();
            }
        },
        refreshStats() {
            fetch('{{ route('api.visitor-stats') }}')
                .then(res => res.json())
                .then(data => {
                    if (data && typeof data === 'object') {
                        this.stats = data;
                    }
                })
                .catch(() => {});
        }
     }">

    {{-- Detail Popup Card (Opens above the button) --}}
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition-card-enter"
         x-transition:enter-start="opacity-0 translate-y-3 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition-card-leave"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-3 scale-95"
         id="visitor-popup-card"
         style="display: none;">
        
        <h3 class="visitor-popup-title">Jumlah Kunjungan</h3>

        <div class="visitor-rows">
            <div class="visitor-row">
                <span class="visitor-row-label">Hari Ini</span>
                <span class="visitor-row-val" x-text="format(stats.today)">{{ number_format($stats['today'], 0, ',', '.') }}</span>
            </div>
            <div class="visitor-row">
                <span class="visitor-row-label">Kemarin</span>
                <span class="visitor-row-val" x-text="format(stats.yesterday)">{{ number_format($stats['yesterday'], 0, ',', '.') }}</span>
            </div>
            <div class="visitor-row">
                <span class="visitor-row-label">Minggu Ini</span>
                <span class="visitor-row-val" x-text="format(stats.this_week)">{{ number_format($stats['this_week'], 0, ',', '.') }}</span>
            </div>
            <div class="visitor-row">
                <span class="visitor-row-label">Minggu Lalu</span>
                <span class="visitor-row-val" x-text="format(stats.last_week)">{{ number_format($stats['last_week'], 0, ',', '.') }}</span>
            </div>
            <div class="visitor-row">
                <span class="visitor-row-label">Bulan Ini</span>
                <span class="visitor-row-val" x-text="format(stats.this_month)">{{ number_format($stats['this_month'], 0, ',', '.') }}</span>
            </div>
            <div class="visitor-row">
                <span class="visitor-row-label">Bulan Lalu</span>
                <span class="visitor-row-val" x-text="format(stats.last_month)">{{ number_format($stats['last_month'], 0, ',', '.') }}</span>
            </div>
            <div class="visitor-row">
                <span class="visitor-row-label">Total Kunjungan</span>
                <span class="visitor-row-val" x-text="format(stats.total)">{{ number_format($stats['total'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Main Floating Pill Button --}}
    <button @click="toggle()"
            type="button"
            id="visitor-pill-btn"
            aria-label="Statistik Kunjungan Desa Cigagade">

        {{-- Left: Door Icon + Today Count --}}
        <div class="visitor-icon-col">
            <svg class="visitor-door-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16M3 21h18" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="14.5" cy="12" r="0.8" fill="currentColor" />
            </svg>
            <span class="visitor-today-num" x-text="format(stats.today)">
                {{ number_format($stats['today'], 0, ',', '.') }}
            </span>
        </div>

        {{-- Middle: Kunjungan Hari Ini --}}
        <div class="visitor-text-col">
            <div>Kunjungan</div>
            <div>Hari Ini</div>
        </div>

        {{-- Right: Chevron Toggle Arrow --}}
        <div class="visitor-chevron-col">
            <svg class="visitor-chevron-svg" :class="{ 'open': open }" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </button>
</div>

<style>
    /* ── Floating Visitor Widget ── */
    #visitor-widget {
        position: fixed;
        bottom: 1.5rem;
        left: 1.5rem;
        z-index: 9998;
        font-family: inherit;
        user-select: none;
    }

    #visitor-pill-btn {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.55rem 1rem 0.55rem 0.9rem;
        background-color: #b5e7a0;
        border: 2px solid #ffffff;
        border-radius: 1.15rem;
        box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.18), 0 4px 6px -2px rgba(0, 0, 0, 0.08);
        color: #ffffff;
        cursor: pointer;
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, background-color 0.2s ease;
        outline: none;
    }

    #visitor-pill-btn:hover {
        background-color: #a7e090;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 14px 28px -4px rgba(0, 0, 0, 0.22), 0 6px 10px -2px rgba(0, 0, 0, 0.1);
    }

    #visitor-pill-btn:active {
        transform: translateY(1px) scale(0.96);
    }

    .visitor-icon-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
    }

    .visitor-door-svg {
        width: 1.55rem;
        height: 1.55rem;
        stroke-width: 2.3;
        display: block;
    }

    .visitor-today-num {
        font-size: 0.78rem;
        font-weight: 900;
        line-height: 1;
        margin-top: 0.25rem;
        letter-spacing: -0.02em;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
    }

    .visitor-text-col {
        display: flex;
        flex-direction: column;
        text-align: left;
        font-weight: 800;
        font-size: 0.98rem;
        line-height: 1.12;
        letter-spacing: -0.015em;
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
    }

    .visitor-chevron-col {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 0.25rem;
    }

    .visitor-chevron-svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke-width: 2.8;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .visitor-chevron-svg.open {
        transform: rotate(180deg);
    }

    /* ── Popup Card ── */
    #visitor-popup-card {
        position: absolute;
        bottom: calc(100% + 0.75rem);
        left: 0;
        width: 17.5rem;
        background-color: #5a5e62;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 1.25rem;
        padding: 1.25rem 1.25rem 1rem 1.25rem;
        box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.4), 0 10px 15px -3px rgba(0, 0, 0, 0.25);
        z-index: 9999;
    }

    .visitor-popup-title {
        font-size: 1.12rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 0.85rem 0;
        letter-spacing: -0.01em;
    }

    .visitor-rows {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .visitor-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.38rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.38);
        font-size: 0.95rem;
    }

    .visitor-row:last-child {
        border-bottom: 1px solid rgba(255, 255, 255, 0.38);
    }

    .visitor-row-label {
        font-weight: 500;
        color: rgba(255, 255, 255, 0.95);
    }

    .visitor-row-val {
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.02em;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        #visitor-widget {
            bottom: 1rem;
            left: 1rem;
        }
        #visitor-pill-btn {
            padding: 0.5rem 0.85rem;
            gap: 0.65rem;
        }
        .visitor-text-col {
            font-size: 0.88rem;
        }
        #visitor-popup-card {
            width: 16rem;
            padding: 1rem;
        }
        .visitor-row {
            font-size: 0.88rem;
        }
    }
</style>
