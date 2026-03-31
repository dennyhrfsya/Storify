<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(5)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function tambah()
    {
        return view('users.tambah');
    }

    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ],
        [
            'name.required' => 'Nama wajib diisi.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => 'user',
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User baru berhasil di <strong>Tambah</strong>');
    }

    public function ubah($id)
    {
        $user = User::findOrFail($id);
        return view('users.ubah', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role'     => 'required|string',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        // Jika password diisi (tidak kosong), update password dengan hash bcrypt
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
                        ->with('success', 'Data user berhasil di <strong>Ubah</strong>');
    }

    public function hapus($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data user berhasil di <strong>Hapus</strong>');
    }
}
