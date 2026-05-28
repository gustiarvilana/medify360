<x-guest-layout>
    <div class="auth-visual slide-in-left" style="background: linear-gradient(135deg, #198754, #20c997);">
        <div>
            <h1 class="fw-bold mb-3">{{ config('app.name') }}</h1>
            <p class="lead">Mulai perjalanan apresiasi budaya perusahaan Anda hari ini.</p>
        </div>
    </div>
    <div class="auth-form slide-in-right">
        <div class="form-box">
            <h2 class="fw-bold mb-2">Buat Akun Baru</h2>
            <p class="text-muted mb-4">Bergabunglah dengan ekosistem positif kami.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required autofocus autocomplete="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" required autocomplete="username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Perusahaan" required autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata Sandi" required autocomplete="new-password">
                    <span class="material-symbols-outlined position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; color:#adb5bd;" onclick="togglePass('password')">visibility</span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required autocomplete="new-password">
                    <span class="material-symbols-outlined position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; color:#adb5bd;" onclick="togglePass('password_confirmation')">visibility</span>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100 btn-auth">Daftar Sekarang</button>
            </form>

            <p class="text-center mt-3 small text-muted">
                Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-success">Masuk</a>
            </p>
        </div>
    </div>

    <script>
        function togglePass(id) {
            const p = document.getElementById(id);
            p.type = p.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
