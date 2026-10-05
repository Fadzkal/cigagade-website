<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Infografis;
use Illuminate\Http\Request;
use Database\Seeders\InfografisSeeder;

class InfografisController extends Controller
{
    /**
     * Tampilkan halaman manajemen infografis berdasarkan kategori / tab.
     */
    public function index(Request $request)
    {
        $allowedTabs = ['penduduk', 'apbdes', 'stunting', 'bansos', 'idm', 'sdgs'];
        $currentTab = $request->query('tab', 'penduduk');

        if (!in_array($currentTab, $allowedTabs)) {
            $currentTab = 'penduduk';
        }

        $items = Infografis::where('category', $currentTab)
            ->orderBy('section')
            ->orderBy('order_index')
            ->get();

        $sections = $items->groupBy('section');

        // Statistik ringkas per kategori
        $tabCounts = [
            'penduduk' => Infografis::where('category', 'penduduk')->count(),
            'apbdes'   => Infografis::where('category', 'apbdes')->count(),
            'stunting' => Infografis::where('category', 'stunting')->count(),
            'bansos'   => Infografis::where('category', 'bansos')->count(),
            'idm'      => Infografis::where('category', 'idm')->count(),
            'sdgs'     => Infografis::where('category', 'sdgs')->count(),
        ];

        return view('dashboard.infografis.index', compact('currentTab', 'sections', 'items', 'tabCounts'));
    }

    /**
     * Simpan update cepat data indikator per tab.
     */
    public function updateBulk(Request $request)
    {
        $tab = $request->input('tab', 'penduduk');
        $values = $request->input('values', []);
        $valuesAlt = $request->input('values_alt', []);
        $titles = $request->input('titles', []);
        $units = $request->input('units', []);

        foreach ($values as $id => $val) {
            $item = Infografis::find($id);
            if ($item) {
                $item->value = $val ?? '0';

                if (isset($valuesAlt[$id])) {
                    $item->value_alt = $valuesAlt[$id];
                }
                if (isset($titles[$id])) {
                    $item->title = $titles[$id];
                }
                if (isset($units[$id])) {
                    $item->unit = $units[$id];
                }

                $item->save();
            }
        }

        return redirect()->route('infografis.admin.index', ['tab' => $tab])
            ->with('success', 'Data infografis kategori ' . strtoupper($tab) . ' berhasil diperbarui!');
    }

    /**
     * Simpan item indikator baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'    => 'required|string|in:penduduk,apbdes,stunting,bansos,idm,sdgs',
            'section'     => 'required|string|max:50',
            'key'         => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'value'       => 'required|string|max:255',
            'value_alt'   => 'nullable|string|max:255',
            'unit'        => 'nullable|string|max:50',
            'icon'        => 'nullable|string|max:100',
            'color'       => 'nullable|string|max:50',
            'order_index' => 'nullable|integer',
        ]);

        $validated['order_index'] = $validated['order_index'] ?? (Infografis::where('category', $validated['category'])->max('order_index') + 1);

        Infografis::create($validated);

        return redirect()->route('infografis.admin.index', ['tab' => $validated['category']])
            ->with('success', 'Indikator infografis baru berhasil ditambahkan!');
    }

    /**
     * Update satu item indikator spesifik.
     */
    public function update(Request $request, Infografis $infografi)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'value'       => 'required|string|max:255',
            'value_alt'   => 'nullable|string|max:255',
            'unit'        => 'nullable|string|max:50',
            'section'     => 'nullable|string|max:50',
            'icon'        => 'nullable|string|max:100',
            'color'       => 'nullable|string|max:50',
            'order_index' => 'nullable|integer',
        ]);

        $infografi->update($validated);

        return redirect()->route('infografis.admin.index', ['tab' => $infografi->category])
            ->with('success', 'Data ' . $infografi->title . ' berhasil diperbarui!');
    }

    /**
     * Hapus item indikator.
     */
    public function destroy(Infografis $infografi)
    {
        $cat = $infografi->category;
        $title = $infografi->title;
        $infografi->delete();

        return redirect()->route('infografis.admin.index', ['tab' => $cat])
            ->with('success', 'Indikator "' . $title . '" berhasil dihapus.');
    }

    /**
     * Reset data ke awal jika dibutuhkan admin.
     */
    public function reset(Request $request)
    {
        $seeder = new InfografisSeeder();
        $seeder->run();

        return redirect()->route('infografis.admin.index', ['tab' => $request->input('tab', 'penduduk')])
            ->with('success', 'Seluruh data infografis berhasil di-reset ke nilai default standar.');
    }
}
