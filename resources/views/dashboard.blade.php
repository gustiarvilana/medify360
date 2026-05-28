@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold mb-1">Halo, {{ Auth::user()->name }} 👋</h2>
        <p class="text-muted mb-0">Mari tingkatkan budaya kerja kita hari ini.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="row g-3 mb-5">
            <div class="col-sm-6 col-lg-3">
                <div class="card stat-card p-3 shadow-sm">
                    <h6 class="text-muted small">Cendol Diterima</h6>
                    <h3 class="fw-bold text-success">{{ $cendolDiterima->count() }}</h3>
                    <small class="text-success">Apresiasi dari rekan</small>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card stat-card p-3 shadow-sm">
                    <h6 class="text-muted small">Cendol Diberikan</h6>
                    <h3 class="fw-bold text-info">{{ $cendolDikirim->count() }}</h3>
                    <div class="progress mt-1" style="height:4px"><div class="progress-bar bg-info" style="width:60%"></div></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card stat-card p-3 shadow-sm">
                    <h6 class="text-muted small">Laporan Bata</h6>
                    <h3 class="fw-bold text-danger">{{ $laporan->count() }}</h3>
                    <small class="text-warning">{{ $laporan->where('status', 'menunggu')->count() }} Menunggu</small>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card stat-card p-3 shadow-sm">
                    <h6 class="text-muted small">Sisa Whistleblow</h6>
                    @php $sisa = Auth::user()->sisaBatasWhistleblow(); $batas = Auth::user()->peran?->batas_whistleblow; @endphp
                    @if(is_null($batas))
                        <h3 class="fw-bold text-primary">∞</h3>
                        <small class="text-muted">Tanpa batas</small>
                    @else
                        <h3 class="fw-bold {{ $sisa <= 1 ? 'text-danger' : ($sisa <= 2 ? 'text-warning' : 'text-primary') }}">{{ $sisa }}/{{ $batas }}</h3>
                        <small class="text-muted">Bulan ini</small>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
            <a href="{{ route('riwayat') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>

        @forelse($recentActivity as $item)
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-3">
            <div class="d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->pengirim->name ?? 'User') }}" class="rounded-circle me-3" width="45">
                <div class="flex-grow-1">
                    <p class="mb-0 fw-bold">{{ $item->pengirim->name ?? 'User' }} <span class="text-muted fw-normal">memberi Cendol ke</span> {{ $item->penerima->name ?? 'User' }}</p>
                    <small class="text-muted">"{{ $item->pesan }}"</small>
                </div>
                <div class="text-center">
                    <span class="material-symbols-outlined text-success">volunteer_activism</span>
                    <div class="small fw-bold">{{ $item->kategori }}</div>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted">
            <p>Belum ada aktivitas. Mulai dengan mengirim Cendol!</p>
        </div>
        @endforelse
    </div>

    <div class="col-lg-4">
        @if($adaTarget)
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-bold mb-3">Penilaian 360</h5>
            <div class="d-flex justify-content-between mb-1">
                <small class="text-muted">Tugas Penilaian</small>
                <small class="fw-bold">{{ $penilaianSelesai }}/{{ $targetPenilaian }}</small>
            </div>
            <div class="progress mb-3" style="height:8px">
                <div class="progress-bar bg-info" style="width: {{ $targetPenilaian > 0 ? ($penilaianSelesai / $targetPenilaian) * 100 : 0 }}%"></div>
            </div>
            <a href="{{ route('penilaian-360.index') }}" class="btn btn-outline-info btn-sm w-100">Mulai Menilai</a>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-bold mb-3">Target Budaya</h5>
            <p class="small text-muted">Kumpulkan 20 Cendol untuk mencapai level "Culture Champion".</p>
            <div class="progress mb-2" style="height: 10px;">
                <div class="progress-bar bg-success" style="width: {{ min(($cendolDiterima->count() / 20) * 100, 100) }}%"></div>
            </div>
            <small class="text-muted">{{ $cendolDiterima->count() }}/20 Cendol terkumpul</small>
        </div>

        <div class="d-grid gap-2 mb-4">
            <button class="btn btn-cendol py-3" data-bs-toggle="modal" data-bs-target="#modalCendol">Kirim Cendol</button>
            <button class="btn btn-bata py-3" data-bs-toggle="modal" data-bs-target="#modalBata">Kirim Bata</button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCendol" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header modal-header-cendol">
                <h5 class="modal-title fw-bold">Kirim Cendol (Apresiasi)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route('cendol.kirim') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Rekan Kerja</label>
                        <select name="id_penerima" class="form-select" required>
                            <option value="">Cari nama...</option>
                            @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->departemen->nama ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="Kolaborasi">Kolaborasi</option>
                            <option value="Semangat">Semangat</option>
                            <option value="Inovasi">Inovasi</option>
                            <option value="Integritas">Integritas</option>
                            <option value="Ketelitian">Ketelitian</option>
                            <option value="Disiplin">Disiplin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pesan Apresiasi</label>
                        <textarea name="pesan" class="form-control" rows="3" placeholder="Tuliskan alasan apresiasi..." required></textarea>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-cendol py-2 fw-bold">Kirim Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBata" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header modal-header-bata">
                <h5 class="modal-title fw-bold">Kirim Bata</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                @php $sisa = Auth::user()->sisaBatasWhistleblow(); $batas = Auth::user()->peran?->batas_whistleblow; @endphp
                @if(!is_null($batas))
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded-3">
                    <small class="fw-bold text-muted">Sisa whistleblow bulan ini</small>
                    <span class="badge {{ $sisa <= 1 ? 'bg-danger' : ($sisa <= 2 ? 'bg-warning text-dark' : 'bg-success') }} fs-6">{{ $sisa }}/{{ $batas }}</span>
                </div>
                @endif
                <form method="POST" action="{{ route('laporan.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Rekan Kerja</label>
                        <select name="id_penerima" class="form-select" required>
                            <option value="">Cari nama...</option>
                            @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->departemen->nama ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Jenis Insiden</label>
                        <select name="tipe" class="form-select" required>
                            <option value="">Pilih jenis...</option>
                            <option value="Ketidakhadiran">Ketidakhadiran</option>
                            <option value="Ketidakjujuran">Ketidakjujuran</option>
                            <option value="Perilaku">Perilaku</option>
                            <option value="Infrastruktur">Infrastruktur</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Detail kejadian..." required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="adalah_anonim" value="1" class="form-check-input" id="anonimCheck">
                        <label class="form-check-label small" for="anonimCheck">Kirim sebagai anonim</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-bata py-2 fw-bold">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
