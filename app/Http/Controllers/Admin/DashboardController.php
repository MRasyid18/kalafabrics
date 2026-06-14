<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pengguna' => User::where('role', 'pengguna')->count(),
            'total_ranger'   => User::where('role', 'ranger')->count(),
            'total_admin'    => User::where('role', 'admin')->count(),
            'total_users'    => User::count(),
        ];

        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users'));
    }
}
