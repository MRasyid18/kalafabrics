<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteDonation;
use App\Models\UserPoint;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class B2bController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Perbaikan: Pastikan kita mengambil 'available_points' dari tabel user_points
        $pointsData = \App\Models\UserPoint::where('user_id', $user->id)->first();
        
        // Jika data belum ada, berikan nilai 0
        $currentPoints = $pointsData ? $pointsData->available_points : 0;
        
        // Menghitung ringkasan statistik limbah yang sudah berstatus 'selesai'
        $totalWeight = \App\Models\WasteDonation::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->sum('weight');

        $pendingPickups = \App\Models\WasteDonation::where('user_id', $user->id)
            ->whereIn('status', ['diajukan', 'kurasi', 'penjemputan'])
            ->count();

        $recentDonations = \App\Models\WasteDonation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('b2b.dashboard', compact('user', 'currentPoints', 'totalWeight', 'pendingPickups', 'recentDonations'));
    }

    /**
     * Tampilkan Formulir Penyerahan/Penjemputan Limbah Baru
     */
    public function createDonation()
    {
        return view('b2b.donations.create');
    }

    /**
     * Simpan Data Formulir Penyerahan Limbah ke Database
     */
    public function storeDonation(Request $request)
    {
        $request->validate([
            'waste_type'      => 'required|string|max:100',
            'weight'          => 'required|numeric|min:0.1',
            'condition'       => 'required|string|max:100',
            'delivery_method' => 'required|in:self_delivery,ranger_pickup',
            'photo'           => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'pickup_date'     => 'required|date|after_or_equal:today',
            'address'         => 'required_if:delivery_method,ranger_pickup|nullable|string',
        ]);

        // Proses Upload Foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('waste_photos', 'public');
        }

        WasteDonation::create([
            'user_id'         => Auth::id(),
            'waste_type'      => $request->waste_type,
            'weight'          => $request->weight,
            'condition'       => $request->condition,
            'delivery_method' => $request->delivery_method,
            'photo_path'      => $photoPath,
            'pickup_date'     => $request->pickup_date,
            'address'         => $request->address,
            'notes'           => $request->notes,
            'status'          => 'diajukan', // Sesuai pipeline baru
        ]);

        return redirect()->route('b2b.dashboard')->with('success', 'Formulir limbah berhasil diajukan dan sedang masuk tahap kurasi Admin!');
    }

    /**
     * Tampilkan Seluruh Riwayat Transaksi Limbah dengan Paginasi
     */
    public function history()
        {
            $user = Auth::user();
            
            // Mengambil semua riwayat donasi milik B2B ini
            $donations = WasteDonation::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
            // Mengambil total poin
            $userPoint = UserPoint::where('user_id', $user->id)->first();
            $currentPoints = $userPoint ? $userPoint->total_points : 0;
            
            // Menghitung total limbah yang statusnya sudah Selesai (divalidasi Ranger)
            $validatedWeight = $donations->where('status', 'selesai')->sum('weight');

            return view('b2b.history', compact('user', 'donations', 'currentPoints', 'validatedWeight'));
        }
    /**
     * Tampilkan Halaman Pelacakan Status Limbah (Waste Tracking)
     */
    public function trackDonation($id)
    {
        // Cari data donasi berdasarkan ID, pastikan itu milik user yang sedang login
        $donation = WasteDonation::where('user_id', Auth::id())->findOrFail($id);
        
        return view('b2b.donations.track', compact('donation'));
    }

    /**
     * Tampilkan Buku Besar Poin Digital & Reward
     */
    public function pointsLedger()
    {
        $user = Auth::user();
        
        // Saldo Poin Saat Ini
        $pointsData = UserPoint::where('user_id', $user->id)->first();
        dd($pointsData);
        $currentPoints = $pointsData ? $pointsData->points : 0;

        // Riwayat Transaksi Poin (Diasumsikan poin masuk jika status limbah 'diterima' atau 'selesai')
        $pointHistory = WasteDonation::where('user_id', $user->id)
            ->whereIn('status', ['diterima', 'selesai'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('b2b.points.index', compact('currentPoints', 'pointHistory'));
    }
}