<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TinyMCEController extends Controller
{
    /**
     * Handle image upload from TinyMCE editor.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|file|max:5120',
        ]);

        $path = $request->file('file')->store('content-images', 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
        ]);
    }
}
