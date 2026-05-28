<x-guest-layout>
    <div class="auth-form slide-in-left">
        <div class="form-box">
            <h2 class="fw-bold mb-2">Selamat Datang Kembali</h2>
            <p class="text-muted mb-4">Masuk ke akun {{ config('app.name') }} Anda.</p>

            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-secondary">Username atau Email</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Username atau email" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label small fw-bold text-secondary">Kata Sandi</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required autocomplete="current-password">
                    <span class="material-symbols-outlined position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; color:#adb5bd; margin-top: 10px;" onclick="togglePass('password')">visibility</span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label small">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-auth">Masuk</button>
            </form>

            <p class="text-center mt-3 text-muted small">
                Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-primary">Daftar</a>
            </p>

            @if (Route::has('password.request'))
                <p class="text-center mb-0">
                    <a href="{{ route('password.request') }}" class="small text-muted">Lupa kata sandi?</a>
                </p>
            @endif
        </div>
    </div>
    <div class="auth-visual" style="background: linear-gradient(135deg, #0d6efd, #0099ff);">
        <div>
            <h1 class="fw-bold mb-3">{{ config('app.name') }}</h1>
            <p class="lead">Platform budaya dan performa kerja terbaik untuk tim modern.</p>
        </div>
    </div>

    <script>
        function togglePass(id) {
            const p = document.getElementById(id);
            p.type = p.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
