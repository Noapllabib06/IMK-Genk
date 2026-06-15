<x-layout.app>
    <x-slot name="title">EduNOTES - Sat-set Task Management</x-slot>

    <section id="home" class="hero-fullscreen text-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <h1 class="display-2 fw-bold mb-4 hero-title">Fokus Kuliah, Bukan Ribet Atur Aplikasi.</h1>
            <p class="lead text-secondary mb-5 px-md-5 fs-4">Manajemen tugas minimalis dengan fitur <strong style="color: #fff;">Quick Add</strong> dan <strong style="color: #fff;">Auto-Reminder H-1</strong> otomatis. Didesain untuk mahasiswa anti-ribet.</p>
            
            <div class="d-flex justify-content-center gap-3">
              <a href="#about" class="btn btn-primary btn-lg px-5 fw-bold rounded-pill py-3 shadow">Mulai Sekarang</a>
              <a href="#" class="btn btn-outline-light btn-lg px-5 fw-bold rounded-pill py-3 border-secondary">Learn More</a>
            </div>

            <div class="mt-5 pt-4">
                <a href="#about" class="text-decoration-none text-secondary opacity-50 scroll-cue">
                    <p class="small text-uppercase tracking-widest mb-1">Scroll untuk fitur unggulan</p>
                    <i class="fa-solid fa-chevron-down bounce fs-4"></i>
                </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="about">
        <div class="container">
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-8">
                    <h6 class="text-primary fw-bold text-uppercase mb-2">What We Offer</h6>
                    <h2 class="display-5 fw-bold text-white mb-4">Semua yang kamu butuhkan dalam satu genggaman.</h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="p-5 bg-card h-100 d-flex flex-column justify-content-between" style="border-left: 6px solid var(--edunotes-blue) !important;">
                        <div>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <h3 class="fw-bold text-white">Input Sat-set (Quick Add)</h3>
                            <p class="text-secondary fs-5">Lupakan alur klik yang panjang. Cukup satu tombol, tulis deadline, dan sistem akan mengurus sisanya.</p>
                        </div>
                        
                        <div class="mt-4 p-4 rounded-4 bg-dark border border-secondary border-opacity-25 shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="flex-grow-1 bg-secondary bg-opacity-10 rounded-pill py-2 px-3 text-secondary border border-secondary border-opacity-25" style="font-size: 13px;">
                                    <i class="fa-solid fa-pen-to-square me-2 text-primary"></i> Laporan Tahap 5 IMK...
                                </div>
                                <div class="bg-primary rounded-pill px-4 py-2 text-white fw-bold shadow-sm" style="font-size: 12px; cursor: pointer;">
                                    SIMPAN
                                </div>
                            </div>

                            <div class="p-3 rounded-3 bg-secondary bg-opacity-5 border-start border-primary border-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fa-regular fa-circle text-secondary"></i>
                                    <span class="text-white fw-medium" style="font-size: 14px;">Laporan Tahap 5 IMK</span>
                                </div>
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger fw-normal" style="font-size: 11px;">Besok, 23:59</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="p-5 bg-card h-100" style="border-left: 6px solid var(--pop-purple) !important;">
                        <div class="icon-box bg-purple bg-opacity-10" style="color: var(--pop-purple);"><i class="fa-solid fa-bell"></i></div>
                        <h4 class="fw-bold text-white">Auto-Reminder H-1</h4>
                        <p class="text-secondary">Sistem secara otomatis menjadwalkan notifikasi peringatan tepat 24 jam sebelum deadline. Tidak perlu lagi pengaturan manual yang membosankan.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="p-5 bg-card h-100" style="border-left: 6px solid var(--pop-teal) !important;">
                        <div class="icon-box bg-teal bg-opacity-10" style="color: var(--pop-teal);"><i class="fa-solid fa-chart-line"></i></div>
                        <h4 class="fw-bold text-white">Visualisasi Progres</h4>
                        <p class="text-secondary">Lihat kemajuan belajarmu melalui Energy Bar yang intuitif. Memberikan kepuasan visual (rewarding) untuk setiap tugas yang selesai.</p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="p-5 bg-card h-100 d-flex flex-column justify-content-between" style="border-left: 6px solid #fff !important;">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <div class="icon-box bg-light bg-opacity-10 text-white"><i class="fa-solid fa-filter"></i></div>
                                <h3 class="fw-bold text-white">Filter Urgensi Otomatis</h3>
                                <p class="text-secondary fs-5">Tugasmu diurutkan otomatis berdasarkan waktu terdekat. Kode warna (Merah, Kuning, Hijau) membantumu menentukan prioritas tanpa perlu berpikir dua kali.</p>
                            </div>
                            <div class="col-md-5 d-none d-md-block text-center">
                                <i class="fa-solid fa-layer-group display-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="p-5 bg-card h-100">
                        <div class="icon-box bg-dark border border-secondary text-white"><i class="fa-solid fa-moon"></i></div>
                        <h4 class="fw-bold text-white">Layar Nyaman (Dark Mode)</h4>
                        <p class="text-secondary">Didesain untuk mahasiswa yang sering begadang. Latar belakang gelap mengurangi emisi cahaya biru agar mata tidak cepat lelah saat belajar malam hari.</p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="p-5 bg-card h-100">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary"><i class="fa-solid fa-graduation-cap"></i></div>
                        <h4 class="fw-bold text-white">Didesain untuk Akademik</h4>
                        <p class="text-secondary">Bukan aplikasi bisnis umum. Struktur data kami disesuaikan dengan kurikulum kampus, mata kuliah, dan kebutuhan nyata mahasiswa Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout.app>