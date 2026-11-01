<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar akun pengguna dengan filter & pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $roleFilter = $request->query('role');
        $rwFilter = $request->query('rw');

        $query = User::withCount('posts');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter) {
            if ($roleFilter === 'rw') {
                $query->where(function ($q) {
                    $q->where('role', 'rw')->orWhereNotNull('rw');
                });
            } elseif ($roleFilter === 'pkk') {
                $query->whereIn('role', ['pkk', 'kader_pkk']);
            } else {
                $query->where('role', $roleFilter);
            }
        }

        if ($rwFilter) {
            $query->where('rw', $rwFilter);
        }

        $users = $query->orderBy('role')->orderBy('rw')->latest()->paginate(15)->withQueryString();

        // Metrik Statistik Akun
        $stats = [
            'total'       => User::count(),
            'superadmin'  => User::where('role', 'superadmin')->count(),
            'rw'          => User::where('role', 'rw')->orWhereNotNull('rw')->count(),
            'pkk'         => User::whereIn('role', ['pkk', 'kader_pkk'])->count(),
        ];

        return view('dashboard.users.index', compact('users', 'stats', 'search', 'roleFilter', 'rwFilter'));
    }

    /**
     * Tampilkan form pembuatan akun baru.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Simpan akun pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', 'in:superadmin,rw,pkk'],
            'rw'       => ['nullable', 'integer', 'min:1', 'max:20', 'required_if:role,rw'],
        ], [
            'name.required'      => 'Nama pengguna wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Alamat email ini sudah terdaftar di sistem.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Peran/Role akun wajib dipilih.',
            'rw.required_if'     => 'Nomor RW wajib dipilih untuk role Pengurus RW.',
        ]);

        User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => $validated['role'],
            'rw'                => $validated['role'] === 'rw' ? (int) $validated['rw'] : null,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')->with('success', "Akun '{$validated['name']}' berhasil ditambahkan ke sistem!");
    }

    /**
     * Tampilkan form edit data akun pengguna.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Perbarui data akun pengguna.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', 'in:superadmin,rw,pkk'],
            'rw'       => ['nullable', 'integer', 'min:1', 'max:20', 'required_if:role,rw'],
        ], [
            'name.required'      => 'Nama pengguna wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah dipakai oleh pengguna lain.',
            'password.min'       => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'role.required'      => 'Peran/Role akun wajib dipilih.',
            'rw.required_if'     => 'Nomor RW wajib dipilih untuk role Pengurus RW.',
        ]);

        // Proteksi: jangan sampai superadmin mencabut hak superadmin akun miliknya sendiri
        if ($user->id === Auth::id() && $validated['role'] !== 'superadmin') {
            return back()->withInput()->with('error', 'Anda tidak dapat menurunkan hak akses akun Anda sendiri dari Superadmin.');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->rw = $validated['role'] === 'rw' ? (int) $validated['rw'] : null;

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', "Data akun '{$user->name}' berhasil diperbarui!");
    }

    /**
     * Hapus akun pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Proteksi 1: Tidak dapat menghapus akun sendiri yang sedang login
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif login.');
        }

        // Proteksi 2: Jangan hapus jika satu-satunya Superadmin
        if ($user->role === 'superadmin' && User::where('role', 'superadmin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus superadmin terakhir pada sistem portal desa.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')->with('success', "Akun '{$name}' telah berhasil dihapus dari sistem.");
    }
}

