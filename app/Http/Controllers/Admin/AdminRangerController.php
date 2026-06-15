<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminRangerController extends Controller
{
    public function index()
    {
        $rangers = User::where('role', 'ranger')->orderBy('created_at', 'desc')->get();
        // View menggunakan nama folder asli (tanpa 's')
        return view('admin.ranger.index', compact('rangers'));
    }

    public function create()
    {
        return view('admin.ranger.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'ranger',
        ]);

        // Route wajib menggunakan 's' (rangers) sesuai web.php
        return redirect()->route('admin.rangers.index')->with('success', 'Ranger berhasil ditambahkan.');
    }

    public function edit(User $ranger)
    {
        return view('admin.ranger.form', compact('ranger'));
    }

    public function update(Request $request, User $ranger)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $ranger->id,
        ]);

        $ranger->name = $request->name;
        $ranger->email = $request->email;
        if ($request->filled('password')) {
            $ranger->password = Hash::make($request->password);
        }
        $ranger->save();

        // Route wajib menggunakan 's' (rangers) sesuai web.php
        return redirect()->route('admin.rangers.index')->with('success', 'Data Ranger diperbarui.');
    }

    public function destroy(User $ranger)
    {
        $ranger->delete();
        // Route wajib menggunakan 's' (rangers) sesuai web.php
        return redirect()->route('admin.rangers.index')->with('success', 'Ranger berhasil dihapus.');
    }
}