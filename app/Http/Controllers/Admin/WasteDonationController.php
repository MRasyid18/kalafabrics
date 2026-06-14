<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WasteDonation;
use App\Models\UserPoint;
use Illuminate\Support\Facades\Auth;

class WasteDonationController extends Controller
{
    /**
     * Tampilkan semua daftar pengajuan limbah B2B
     */
    public function index()
    {
        // Mengambil semua data donasi limbah beserta data usernya
        $donations = WasteDonation::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.waste.index', compact('donations'));
    }

    /**
     * Tampilkan detail pengajuan untuk dikurasi
     */
    public function show($id)
    {
        $donation = WasteDonation::with('user')->findOrFail($id);
        return view('admin.waste.show', compact('donation'));
    }

    /**
     * Update status tracking dan distribusikan poin jika selesai
     */
    public function updateStatus(Request $request, $id)
    {
        $donation = WasteDonation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:diajukan,kurasi,penjemputan,diterima,selesai,ditolak',
            'verification_notes' => 'nullable|string',
            'final_weight' => 'nullable|numeric|min:0.1',
            'awarded_points' => 'nullable|integer|min:0' // Tambahkan validasi poin manual
        ]);

        $donation->status = $request->status;
        $donation->verification_notes = $request->verification_notes;
        $donation->admin_verified_by = Auth::user()->name;
        $donation->verified_at = now();

        // JIKA STATUS SELESAI: Update berat aktual & cairkan poin sesuai input admin
        if ($request->status === 'selesai' && $request->final_weight && $request->awarded_points) {
            $donation->weight = $request->final_weight;
            
            // Simpan poin yang diberikan oleh admin
            $pointsToAward = $request->awarded_points;
            $donation->points_awarded = $pointsToAward;

            // Masukkan poin ke dompet digital B2B (UserPoint)
            $userPoint = UserPoint::firstOrCreate(
                ['user_id' => $donation->user_id],
                ['total_points' => 0, 'redeemed_points' => 0, 'available_points' => 0, 'points' => 0]
            );
            
            // Increment saldo poin B2B
            $userPoint->increment('points', $pointsToAward);
            
            // Trik untuk mengupdate total kontribusi berat di Dashboard B2B
            // Kita pastikan saat statusnya "selesai" (bukan hanya "validated"), controller B2B akan menghitungnya.
        }

        $donation->save();

        return redirect()->route('admin.waste.index')->with('success', 'Status pengajuan limbah berhasil diperbarui dan Poin telah dicairkan!');
    }
}