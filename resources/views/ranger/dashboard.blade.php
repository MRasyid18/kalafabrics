@extends('layouts.app')
@section('title', 'Dashboard Ranger')

@push('styles')
<style>
    .ranger-tabs { display:flex; gap:16px; border-bottom:1px solid #d8d4c8; margin-bottom:24px; }
    .r-tab { padding:12px 20px; font-weight:600; color:#9a9988; cursor:pointer; border-bottom:2px solid transparent; }
    .r-tab.active { color:#2d3a1e; border-bottom-color:#2d3a1e; }
    .r-pane { display:none; }
    .r-pane.active { display:block; }
    .stat-card { background:#faf9f6; border:1px solid #d8d4c8; border-radius:12px; padding:20px; text-align:center; }
    .stat-val { font-size:32px; font-weight:600; color:#2d6a4f; margin-bottom:8px; }
    .task-card { background:white; border:1px solid #d8d4c8; border-radius:12px; padding:20px; margin-bottom:16px; }
</style>
@endpush

@section('content')
<section style="padding:40px 0; min-height:70vh;">
    <div class="container" style="max-width:900px;">
        
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <div style="width:60px; height:60px; border-radius:50%; background:#2d3a1e; color:white; display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:600;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="margin-bottom:4px;">Halo, Ranger {{ explode(' ', $user->name)[0] }}!</h2>
                <div style="color:#6b6b5a; font-size:14px;">Siap membuat dampak positif hari ini?</div>
            </div>
        </div>

        <div class="ranger-tabs">
            <div class="r-tab active" onclick="switchTab(event, 'ringkasan')">Ringkasan & Misi Aktif</div>
            <div class="r-tab" onclick="switchTab(event, 'cari-misi')">Cari Tugas & Misi</div>
            <div class="r-tab" onclick="switchTab(event, 'pengaturan')">Pengaturan Profil</div>
        </div>

        <div id="ringkasan" class="r-pane active">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:32px;">
                <div class="stat-card">
                    <div class="stat-val">{{ number_format($totalHours, 1) }}</div>
                    <div style="font-size:14px; color:#6b6b5a;">Total Jam Terbang (Kerelawanan)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-val">{{ number_format($user->point->total_points ?? 0) }}</div>
                    <div style="font-size:14px; color:#6b6b5a;">Poin Dampak (Impact Points)</div>
                </div>
            </div>

            <h3 style="margin-bottom:16px;">Misi Sedang Dikerjakan</h3>
            @forelse($activeMissions as $mission)
                <div class="task-card" style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <h4 style="margin-bottom:8px; color:#2d3a1e;">{{ $mission->task->title }}</h4>
                        <div style="font-size:13px; color:#6b6b5a;">📍 {{ $mission->task->location }} | 🕒 Jadwal: {{ $mission->task->scheduled_datetime->format('d M Y, H:i') }}</div>
                        <div style="font-size:13px; color:#6b6b5a; margin-top:4px;">🎯 Potensi: {{ $mission->task->hours_commitment }} Jam & {{ $mission->task->points_reward }} Poin</div>
                    </div>
                    <form action="{{ route('ranger.tasks.complete', $mission->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda sudah benar-benar menyelesaikan misi ini di lapangan?');">Tandai Selesai</button>
                    </form>
                </div>
            @empty
                <div style="text-align:center; padding:30px; border:1px dashed #ccc; border-radius:12px; color:#9a9988;">
                    Tidak ada misi yang sedang dikerjakan. Buka tab "Cari Tugas & Misi".
                </div>
            @endforelse
        </div>

        <div id="cari-misi" class="r-pane">
            <h3 style="margin-bottom:16px;">Tugas Kerelawanan Terbuka</h3>
            @forelse($availableTasks as $task)
                <div class="task-card">
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                        <h4 style="color:#2d3a1e; margin:0;">{{ $task->title }}</h4>
                        <span style="background:#fdf0dc; color:#8b6914; padding:2px 10px; border-radius:99px; font-size:12px; font-weight:600;">{{ strtoupper($task->task_type) }}</span>
                    </div>
                    <p style="font-size:14px; color:#4a4a4a; margin-bottom:12px;">{{ $task->description }}</p>
                    <div style="display:flex; gap:20px; font-size:13px; color:#6b6b5a; margin-bottom:16px;">
                        <div>📍 {{ $task->location }}</div>
                        <div>🕒 {{ $task->scheduled_datetime->format('d M Y, H:i') }}</div>
                        <div>👥 Relawan: {{ $task->assigned_volunteers }}/{{ $task->required_volunteers }}</div>
                    </div>
                    
                    <form action="{{ route('ranger.tasks.take', $task->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="background:#c9a85c; color:white; width:100%; border-radius:8px; padding:10px; font-weight:600;">Ambil Misi Ini (+{{ $task->points_reward }} Poin)</button>
                    </form>
                </div>
            @empty
                <div style="text-align:center; padding:30px; border:1px dashed #ccc; border-radius:12px; color:#9a9988;">
                    Saat ini belum ada tugas baru dari Admin KalaFabrics.
                </div>
            @endforelse
        </div>

        <div id="pengaturan" class="r-pane">
            <div class="task-card">
                <form action="{{ route('ranger.profile.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group" style="margin-bottom:16px;">
                        <label style="font-weight:600; display:block; margin-bottom:8px;">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control-box" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;" required>
                    </div>
                    <div class="form-group" style="margin-bottom:16px;">
                        <label style="font-weight:600; display:block; margin-bottom:8px;">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control-box" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;" required>
                    </div>
                    <div class="form-group" style="margin-bottom:24px;">
                        <label style="font-weight:600; display:block; margin-bottom:8px;">Kata Sandi Baru (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah" class="form-control-box" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan Profil</button>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    function switchTab(evt, tabId) {
        let tabs = document.getElementsByClassName("r-tab");
        for (let i = 0; i < tabs.length; i++) { tabs[i].classList.remove("active"); }
        
        let panes = document.getElementsByClassName("r-pane");
        for (let i = 0; i < panes.length; i++) { panes[i].classList.remove("active"); }
        
        document.getElementById(tabId).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>
@endpush