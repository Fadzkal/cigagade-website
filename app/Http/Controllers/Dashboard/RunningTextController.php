<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RunningText;
use Illuminate\Http\Request;

class RunningTextController extends Controller
{
    /**
     * Display a listing of running texts.
     */
    public function index()
    {
        $runningTexts = RunningText::orderBy('order')->orderByDesc('id')->get();

        return view('dashboard.running_texts.index', compact('runningTexts'));
    }

    /**
     * Store a newly created running text in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:500',
            'url' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:30',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['badge'] = $validated['badge'] ? strtoupper($validated['badge']) : 'INFO';
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? (RunningText::max('order') + 1);

        RunningText::create($validated);

        return redirect()->route('running-texts.index')->with('success', 'Teks berjalan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified running text.
     */
    public function edit(RunningText $runningText)
    {
        return view('dashboard.running_texts.edit', compact('runningText'));
    }

    /**
     * Update the specified running text in storage.
     */
    public function update(Request $request, RunningText $runningText)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:500',
            'url' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:30',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['badge'] = $validated['badge'] ? strtoupper($validated['badge']) : 'INFO';
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $runningText->order;

        $runningText->update($validated);

        return redirect()->route('running-texts.index')->with('success', 'Teks berjalan berhasil diperbarui!');
    }

    /**
     * Toggle active status.
     */
    public function toggle(RunningText $runningText)
    {
        $runningText->is_active = !$runningText->is_active;
        $runningText->save();

        return redirect()->route('running-texts.index')->with('success', 'Status teks berjalan berhasil diubah!');
    }

    /**
     * Remove the specified running text from storage.
     */
    public function destroy(RunningText $runningText)
    {
        $runningText->delete();

        return redirect()->route('running-texts.index')->with('success', 'Teks berjalan berhasil dihapus!');
    }
}
