<?php

namespace App\Http\Controllers;

use App\Models\VolunteerTask;
use App\Models\VolunteerTaskAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RangerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // 1. Ringkasan: Hitung Total Jam Terbang
        $totalHours = VolunteerTaskAssignment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('actual_hours');

        // 2. Misi Aktif (Sedang Dikerjakan)
        $activeMissions = VolunteerTaskAssignment::with('task')
            ->where('user_id', $user->id)
            ->whereIn('status', ['accepted', 'pending'])
            ->get();

        // 3. Tugas & Misi (Misi Tersedia di Lapangan)
        $myTaskIds = VolunteerTaskAssignment::where('user_id', $user->id)->pluck('volunteer_task_id');
        $availableTasks = VolunteerTask::where('status', 'open')
            ->whereNotIn('id', $myTaskIds) // Jangan tampilkan misi yang sudah diambil
            ->orderBy('scheduled_datetime', 'asc')
            ->get();

        return view('ranger.dashboard', compact('user', 'totalHours', 'activeMissions', 'availableTasks'));
    }

    public function takeTask(Request $request, $id)
    {
        $task = VolunteerTask::findOrFail($id);

        if ($task->assigned_volunteers >= $task->required_volunteers) {
            return back()->with('error', 'Maaf, kuota relawan untuk misi ini sudah penuh.');
        }

        // Masukkan relawan ke dalam misi
        VolunteerTaskAssignment::create([
            'user_id' => Auth::id(),
            'volunteer_task_id' => $task->id,
            'status' => 'accepted'
        ]);

        $task->increment('assigned_volunteers');

        return back()->with('success', 'Berhasil mengambil misi: ' . $task->title . '. Silakan cek tab Misi Aktif.');
    }

    public function completeTask(Request $request, $id)
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
            $request->validate(['password' => 'min:8']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Data profil Anda berhasil diperbarui.');
    }
}