<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <style>
        .toast-alert { animation: slideInRight 0.35s ease-out; min-width: 320px; border-radius: 12px; }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .toast-alert .toast-body { font-size: 0.9rem; }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand fw-bold ms-2" href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
            <div class="d-flex align-items-center gap-2 me-2">
                <div class="dropdown">
                    <button class="btn btn-dark border-0 position-relative p-1" type="button" id="notifBell" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">notifications</span>
                        <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; display: none;">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow" id="notifDropdown" aria-labelledby="notifBell" style="width: 340px; max-height: 400px; overflow-y: auto;">
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                            <strong class="small">Notifikasi</strong>
                            <button class="btn btn-sm btn-link text-decoration-none p-0" id="markAllRead">Tandai dibaca</button>
                        </div>
                        <div id="notifList">
                            <div class="text-center text-muted py-4 small">Memuat...</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                        <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow">
                        <li><a class="dropdown-item" href="{{ route('pengaturan') }}">Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('pengaturan') }}">Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div id="sidebar-placeholder" class="sidebar d-none d-lg-block">
        @include('layouts.sidebar')
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar">
        <div class="offcanvas-header bg-dark text-white">
            <h5 class="offcanvas-title fw-bold">{{ config('app.name') }}</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('layouts.sidebar')
        </div>
    </div>

    <main class="main-content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div class="toast-alert toast show align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
            <div class="d-flex">
                <span class="material-symbols-outlined ms-3 my-auto">check_circle</span>
                <div class="toast-body fw-semibold">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div class="toast-alert toast show align-items-center text-bg-danger border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
            <div class="d-flex">
                <span class="material-symbols-outlined ms-3 my-auto">error</span>
                <div class="toast-body fw-semibold">{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <script>
    function initSelect2(container) {
        $(container || document).find('select.form-select').each(function() {
            var $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) return;
            var opts = {
                theme: 'bootstrap-5',
                width: '100%',
                minimumResultsForSearch: 0,
            };
            if ($el.closest('.modal').length) {
                opts.dropdownParent = $el.closest('.modal');
            }
            $el.select2(opts);
        });
    }

    $(document).ready(function() {
        initSelect2();
        $(document).on('shown.bs.modal', function(e) {
            initSelect2(e.target);
        });

        function playNotifSound() {
            try {
                var ctx = new (window.AudioContext || window.webkitAudioContext)();
                var osc = ctx.createOscillator();
                var gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 880;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0.3, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.4);
                setTimeout(function() {
                    var osc2 = ctx.createOscillator();
                    var gain2 = ctx.createGain();
                    osc2.connect(gain2);
                    gain2.connect(ctx.destination);
                    osc2.frequency.value = 1320;
                    osc2.type = 'sine';
                    gain2.gain.setValueAtTime(0.2, ctx.currentTime);
                    gain2.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
                    osc2.start(ctx.currentTime);
                    osc2.stop(ctx.currentTime + 0.3);
                }, 150);
            } catch(e) {}
        }

        var lastCount = 0;
        function loadNotif() {
            $.get('{{ route("notifikasi.unread") }}', function(data) {
                if (data.count > lastCount) { playNotifSound(); }
                lastCount = data.count;
                var badge = $('#notifBadge');
                if (data.count > 0) { badge.text(data.count).show(); } else { badge.hide(); }
                var list = $('#notifList');
                if (data.notifications.length === 0) {
                    list.html('<div class="text-center text-muted py-4 small">Tidak ada notifikasi</div>');
                } else {
                    var html = '';
                    data.notifications.forEach(function(n) {
                        var icon = n.type === 'cendol' ? 'volunteer_activism text-success' : n.type === 'bata' ? 'report text-danger' : 'notifications';
                        html += '<a href="' + n.url + '" class="dropdown-item d-flex align-items-start gap-2 px-3 py-2 notif-item" data-id="' + n.id + '">';
                        html += '<span class="material-symbols-outlined ' + icon + '" style="font-size: 20px;">' + icon.split(' ')[0] + '</span>';
                        html += '<div class="flex-grow-1"><div class="small">' + n.message + '</div><small class="text-muted">' + n.time + '</small></div>';
                        html += '</a>';
                    });
                    list.html(html);
                }
            });
        }

        loadNotif();
        setInterval(loadNotif, 15000);

        $(document).on('click', '.notif-item', function() {
            var id = $(this).data('id');
            $.post('{{ url("notifikasi") }}/' + id + '/read', { _token: '{{ csrf_token() }}' });
        });

        $('#markAllRead').on('click', function() {
            $.post('{{ route("notifikasi.read-all") }}', { _token: '{{ csrf_token() }}' }, function() {
                $('#notifBadge').hide();
                $('#notifList').html('<div class="text-center text-muted py-4 small">Tidak ada notifikasi</div>');
            });
        });
    });
    </script>
    @stack('scripts')
</body>
</html>
