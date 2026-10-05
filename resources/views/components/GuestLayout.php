<?php

namespace App\View\Components;

use App\Models\Setting; // Pastikan model Setting diimpor
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        // Ambil logo path dari database settings
        $settings = Setting::pluck('value', 'key');
        $logoPath = $settings['logo_path'] ?? null;

        return view('layouts.guest', [
            'logoPath' => $logoPath
        ]);
    }
}
