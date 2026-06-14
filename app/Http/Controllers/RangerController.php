<?php

namespace App\Http\Controllers;

use App\Models\VolunteerTask;
use App\Models\VolunteerTaskAssignment;
use App\Models\User;
use App\Models\WasteDonation;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RangerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // 1. DATA MISI & JAM TERBANG (Fitur Lama)
        $totalHours = VolunteerTaskAssignment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('actual_hours');

        $activeMissions = VolunteerTaskAssignment::with('task')
            ->where('user_id', $user->id)
            ->whereIn('status', ['accepted', 'pending'])
            ->get();

        $myTaskIds = VolunteerTaskAssignment::where('user_id', $user->id)->pluck('volunteer_task_id');
        $availableTasks = VolunteerTask::where('status', 'open')
            ->whereNotIn('id', $myTaskIds)
            ->orderBy('scheduled_datetime', 'asc')
            ->get();

        // 2. DATA MODUL OPERASIONAL RANGER (Fitur Baru)
        
        // Modul Inbound Logistics: Dispatcher Penyortiran Limbah
        $sortingTasks = collect([]);
        if (class_exists('\App\Models\WasteDonation')) {
            $sortingTasks = WasteDonation::with('user')
                ->whereIn('status', ['diajukan', 'kurasi'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        // Modul Event & Workshop Management: Jadwal Terdekat
        $upcomingEvents = collect([]);
        if (class_exists('\App\Models\Workshop')) {
            $upcomingEvents = Workshop::where('start_datetime', '>=', now())
                ->orderBy('start_datetime', 'asc')
                ->take(3)
                ->get();
        }

        return view('ranger.dashboard', compact(
            'user', 'totalHours', 'activeMissions', 'availableTasks',
            'sortingTasks', 'upcomingEvents'
        ));
    }

    public function takeTask($id)
    {
        $task = VolunteerTask::findOrFail($id);

        // Cek kuota
        $assignedCount = VolunteerTaskAssignment::where('volunteer_task_id', $id)->count();
        if ($assignedCount >= $task->quota) {
            return back()->with('error', 'Maaf, kuota untuk misi ini sudah penuh.');
        }

        VolunteerTaskAssignment::create([
            'volunteer_task_id' => $id,
            'user_id' => Auth::id(),
            'status' => 'accepted',
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Misi berhasil diambil! Silakan cek tab Misi Aktif.');
    }

    public function completeTask($id)
    {
        $assignment = VolunteerTaskAssignment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $task = $assignment->task;

        // Tandai selesai dan rekam jam terbang
        $assignment->update([
            'status' => 'completed',
            'actual_hours' => $task->hours_commitment,
            'completed_at' => now(),
        ]);

        // Tambah Poin Gamifikasi ke User
        $userPoint = \App\Models\UserPoint::firstOrCreate(['user_id' => Auth::id()]);
        $userPoint->increment('total_points', $task->points_reward);
        $userPoint->increment('available_points', $task->points_reward);

        return back()->with('success', 'Luar biasa! Anda mendapatkan ' . $task->hours_commitment . ' Jam Terbang & ' . $task->points_reward . ' Poin.');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // --- Endpoint API Placeholder untuk Modul Lapangan ---
    public function validateWaste(Request $request, $id) {
        // Logika Form Validasi Berat & Grading Kelayakan
    }

    public function scanTicket(Request $request) {
        // Logika validasi QR Code peserta Workshop
    }

    public function uploadMedia(Request $request) {
        // Logika CMS Uploader ke Cloud Storage
    }

    public function showValidateWaste($id)
    {
        // Ambil data donasi beserta data user mitra B2B-nya
        $donation = WasteDonation::with('user')->findOrFail($id);
        
        // Pastikan hanya yang berstatus diajukan atau kurasi yang bisa divalidasi
        if (!in_array($donation->status, ['diajukan', 'kurasi'])) {
            return redirect()->route('ranger.dashboard')->with('error', 'Limbah ini sudah divalidasi atau tidak valid.');
        }

        return view('ranger.waste_validate', compact('donation'));
    }

    public function processValidateWaste(Request $request, $id)
    {
        // Validasi inputan dari Ranger
        $request->validate([
            'actual_weight' => 'required|numeric|min:0.1',
            'grading' => 'required|in:layak,campur,tidak_layak',
            'notes' => 'nullable|string|max:500'
        ]);

        $donation = WasteDonation::findOrFail($id);

        // Update status donasi menjadi 'selesai' dan perbarui beratnya dengan berat aktual timbangan
        $donation->update([
            'weight' => $request->actual_weight,
            'status' => 'selesai',
        ]);

        // LOGIKA GAMIFIKASI: Kalkulasi poin berdasarkan Grading
        // - Layak = 50 Poin / Kg
        // - Campur = 25 Poin / Kg
        // - Tidak Layak = 0 Poin
        $pointsEarned = 0;
        if ($request->grading === 'layak') {
            $pointsEarned = floor($request->actual_weight * 50);
        } elseif ($request->grading === 'campur') {
            $pointsEarned = floor($request->actual_weight * 25);
        }

        // Jika mendapatkan poin, tambahkan ke saldo Mitra B2B
        if ($pointsEarned > 0) {
            $userPoint = \App\Models\UserPoint::firstOrCreate(['user_id' => $donation->user_id]);
            $userPoint->increment('total_points', $pointsEarned);
            $userPoint->increment('available_points', $pointsEarned);
        }

        // Opsional: Simpan $request->notes (catatan ranger) ke database jika Anda memiliki tabel activity logs.

        return redirect()->route('ranger.dashboard')->with('success', "Validasi berhasil! Status limbah telah diperbarui dan " . $pointsEarned . " poin otomatis dikirim ke Mitra.");
    }
}