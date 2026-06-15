<x-layout.app>
    <x-slot name="title">EduNOTES - Register</x-slot>

    <!-- Dekorasi Cahaya Blur Belakang -->
    <div class="bg-decor"><span class="decor-1"></span><span class="decor-2"></span></div>
    
    <div class="page-wrapper fade-in">
        <div class="auth-card">
            <div class="text-center mb-4">
                <h2 class="hero-title fw-bold" style="font-weight: 800;">EduNOTES</h2>
                <p class="text-secondary mt-2">Buat akun baru ✨</p>
            </div>
            <form action="/register" method="POST">
                @csrf <div class="mb-3">
                    <label class="small fw-bold text-secondary mb-1">Nama Lengkap</label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control form-control-dark" placeholder="Masukkan nama lengkap" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold text-secondary mb-1">Email</label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control form-control-dark" placeholder="Masukkan email" required>
                    </div>
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="small fw-bold text-secondary mb-1">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control form-control-dark" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary-custom mb-3">Buat Akun</button>
                <p class="text-center small text-secondary">Sudah punya akun? <a href="/login" class="text-primary text-decoration-none fw-bold">Masuk di sini</a></p>
            </form>
        </div>
    </div>
</x-layout.app>