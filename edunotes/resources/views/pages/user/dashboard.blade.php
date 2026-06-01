<x-layout.user>
    <x-slot name="title">Dasbor Saya | EduNOTES</x-slot>

    <!-- KONTAINER UTAMA DASBOR -->
    <div class="app-container" id="appContainer">

        <!-- 1. SIDEBAR KIRI -->
        <aside class="sidebar">
            <div class="logo"><i class="fa-solid fa-bolt"></i> EduNOTES</div>
            <nav class="nav-menu">
                <div class="nav-item active" id="nav-dashboard" onclick="showPage('dashboard')"><i class="fa-solid fa-border-all"></i> Dasbor Saya</div>
                <div class="nav-item" id="nav-calendar" onclick="showPage('calendar')"><i class="fa-regular fa-calendar"></i> Kalender</div>
                <div class="nav-item" id="nav-history" onclick="showPage('history')"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</div>
            </nav>
            
            <div style="margin-top: auto; padding-top: 16px; border-top: 1px solid #333;">
                <div class="nav-item" id="nav-account" onclick="showPage('account')"><i class="fa-regular fa-user"></i> Account</div>
            </div>
        </aside>

        <!-- 2. KONTEN TENGAH -->
        <main class="main-content">
            <header class="header">
                <h1 class="page-title" id="mainTitle">Dasbor Saya</h1>
                <div style="display: flex; gap: 16px;">
                    <button class="btn-quick-add" style="background: #2a2a2a; border: 1px solid #444;" onclick="toggleAIPanel()">
                        <i class="fa-solid fa-robot"></i> AI Panel
                    </button>
                    <button class="btn-quick-add" onclick="toggleModal()">
                        <i class="fa-solid fa-plus"></i> Tambah Tugas Cepat
                    </button>
                </div>
            </header>

            <!-- HALAMAN 1: DASBOR -->
            <div id="page-dashboard" class="page active">
                <div class="progress-widget">
                    <div class="progress-circle" id="progress-circle-bar"><span id="progress-percent" style="z-index:1; font-weight:700; font-size:16px;">0%</span></div>
                    <div>
                        <h3 style="font-size:13px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Progres Mingguan</h3>
                        <p style="font-size:22px; font-weight:700;" id="progress-text">0 dari 0 Tugas Selesai</p>
                    </div>
                </div>
                <div class="task-grid" id="task-grid-dashboard"></div>
            </div>

            <!-- HALAMAN 2: KALENDER -->
            <div id="page-calendar" class="page">
                <div style="background: var(--card-dark); padding: 24px; border-radius: 16px; border: 1px solid #333;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <button onclick="gantibulan(-1)" style="background: rgba(255,255,255,0.05); border: 1px solid #444; color: #fff; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; transition: 0.2s;" onmouseover="this.style.borderColor='var(--edunotes-blue)'" onmouseout="this.style.borderColor='#444'">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <h2 id="cal-month-label" style="font-size: 18px; font-weight: 700; color: #fff;"></h2>
                        <button onclick="gantibulan(1)" style="background: rgba(255,255,255,0.05); border: 1px solid #444; color: #fff; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; transition: 0.2s;" onmouseover="this.style.borderColor='var(--edunotes-blue)'" onmouseout="this.style.borderColor='#444'">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; margin-bottom: 12px; font-weight: 700; color: var(--text-muted); font-size: 13px;">
                        <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                    </div>
                    <div id="calendar-grid"></div>
                </div>
                <div id="agenda-panel" style="display: none; background: var(--card-dark); padding: 24px; border-radius: 16px; border: 1px solid #333; margin-top: 24px;">
                    <h3 style="font-size:18px; margin-bottom:16px; color:#fff;">Agenda: <span id="agenda-date" style="color:var(--edunotes-blue);"></span></h3>
                    <div class="task-grid" id="agenda-task-grid"></div>
                </div>
            </div>

            <!-- HALAMAN 3: HISTORY -->
            <div id="page-history" class="page">
                <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
                    <button onclick="filterHistory('semua')" class="filter-btn active" id="filter-semua">Semua</button>
                    <button onclick="filterHistory('selesai')" class="filter-btn" id="filter-selesai">✅ Selesai</button>
                    <button onclick="filterHistory('terlewat')" class="filter-btn" id="filter-terlewat">❌ Terlewat</button>
                    <button onclick="filterHistory('dihapus')" class="filter-btn" id="filter-dihapus">🗑️ Dihapus</button>
                </div>
                <div class="task-grid" id="history-grid"></div>
            </div>

            <!-- HALAMAN 4: ACCOUNT -->
            <div id="page-account" class="page">
                <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px 32px; margin-bottom:24px; display:flex; align-items:center; gap:24px;">
                    <div style="width:72px; height:72px; border-radius:50%; background:var(--normal-teal); display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:800; color:#000; flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 style="font-size:22px; font-weight:700; color:#fff; margin-bottom:4px;" id="disp-name">{{ auth()->user()->name }}</h2>
                        <p style="font-size:14px; color:var(--text-muted); margin-bottom:10px;" id="disp-email">{{ auth()->user()->email }}</p>
                        <span style="font-size:12px; font-weight:700; padding:4px 12px; border-radius:20px; background:rgba(13,110,253,0.15); color:var(--edunotes-blue); display:inline-block;"><i class="fa-solid fa-medal" style="margin-right:4px;"></i> Mahasiswa Aktif</span>
                    </div>
                </div>

                <div class="account-grid">
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                            <h3 style="font-size:13px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;"><i class="fa-regular fa-user" style="margin-right:6px;"></i> Informasi Pribadi</h3>
                            <div class="input-group">
                                <label class="input-label">Nama Lengkap</label>
                                <input type="text" class="input-control" id="prof-nama" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="input-group">
                                <label class="input-label">Email</label>
                                <input type="email" class="input-control" id="prof-email" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="input-group" style="margin-bottom:24px;">
                                <label class="input-label">Jurusan</label>
                                <input type="text" class="input-control" id="prof-jurusan" value="Teknik Informatika" readonly>
                            </div>
                            <button id="btn-edit-profil" onclick="toggleEditProfil()" style="width:100%; background:var(--edunotes-blue); color:#fff; border:none; padding:12px; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px; transition:0.2s;">
                                <i class="fa-solid fa-pen" style="margin-right:6px;"></i> Edit Profil
                            </button>
                        </div>

                        <div class="danger-zone" style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                            <h3 style="color:var(--urgent-red); font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;"><i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i> Danger Zone</h3>
                            <div class="sec-row">
                                <div>
                                    <p style="font-size:14px; font-weight:600; color:#fff;">Hapus Semua Tugas</p>
                                    <p style="font-size:12px; color:var(--text-muted); margin-top:2px;">Tindakan ini tidak bisa dibatalkan</p>
                                </div>
                                <button class="btn-danger-outline" onclick="hapusSemuaTugas()">Hapus</button>
                            </div>
                            <div class="sec-row">
                                <div>
                                    <p style="font-size:14px; font-weight:600; color:#fff;">Logout / Keluar</p>
                                    <p style="font-size:12px; color:var(--text-muted); margin-top:2px;">Akhiri sesi saat ini</p>
                                </div>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-danger-solid">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                        <h3 style="font-size:13px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;"><i class="fa-solid fa-lock" style="margin-right:6px;"></i> Keamanan</h3>
                        <div class="sec-row">
                            <div>
                                <p style="font-size:14px; font-weight:600; color:#fff;">Password</p>
                                <p style="font-size:12px; color:var(--text-muted); margin-top:2px;">Terakhir diubah 30 hari lalu</p>
                            </div>
                            <button class="btn-outline-gray" onclick="toggleModalPassword()">Ubah</button>
                        </div>
                    </div>

                    <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                        <h3 style="font-size:13px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;"><i class="fa-regular fa-bell" style="margin-right:6px;"></i> Notifikasi</h3>
                        <div class="sec-row">
                            <p style="font-size:14px; font-weight:600; color:#fff;">Pengingat deadline</p>
                            <div onclick="toggleNotif(this)" class="toggle-switch on"><div class="knob"></div></div>
                        </div>
                        <div class="sec-row">
                            <p style="font-size:14px; font-weight:600; color:#fff;">Saran dari AI</p>
                            <div onclick="toggleNotif(this)" class="toggle-switch on"><div class="knob"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- 3. AI PANEL KANAN -->
        <aside class="ai-panel">
            <div style="padding: 24px; border-bottom: 1px solid #333; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: 700; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-wand-magic-sparkles" style="color:var(--normal-teal)"></i> Asisten AI
                </div>
                <i class="fa-solid fa-xmark" style="cursor:pointer; color:var(--text-muted);" onclick="toggleAIPanel()"></i>
            </div>
            <div style="padding: 24px; overflow-y: auto;">
                <div class="suggestion-box" style="border-left: 3px solid var(--urgent-red);">
                    <h4 style="font-size:14px; margin-bottom:6px;"><i class="fa-solid fa-bolt" style="color:var(--urgent-red); margin-right:4px;"></i> Tindakan Disarankan</h4>
                    <p style="font-size:13px; color:var(--text-muted); line-height:1.5;">Prioritaskan <strong style="color:#fff">Laporan IMK Tahap 4</strong>. Tenggat waktu tersisa kurang dari 2 jam.</p>
                </div>
                <button onclick="generateJadwalAI()" style="width:100%; background:#2a2a2a; color:#fff; border:1px solid #444; padding:12px; border-radius:8px; cursor:pointer; font-weight:600;">
                    <i class="fa-solid fa-bolt" style="color:#fff; margin-right:4px;"></i> Generate Jadwal Optimal
                </button>
            </div>
        </aside>
    </div> <!-- END APP CONTAINER -->

    <!-- SEMUA MODAL & TOAST -->
    <div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
        <div class="modal-window">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700; color:#fff;"><i class="fa-solid fa-plus" style="color:var(--edunotes-blue); margin-right:8px;"></i>Tambah Tugas Baru</h2>
                <i class="fa-solid fa-xmark" onclick="toggleModal()" style="cursor:pointer; color:var(--text-muted); font-size:18px;"></i>
            </div>
            <div style="display:flex; flex-direction:column; gap:18px;">
                <div><label class="modal-label">Judul Tugas</label><input class="modal-input" id="input-judul" type="text" placeholder="Contoh: Laporan IMK"></div>
                <div><label class="modal-label">Mata Kuliah</label><input class="modal-input" id="input-mapel" type="text" placeholder="Contoh: Desain Pengalaman Pengguna"></div>
                <div><label class="modal-label">Deadline & Jam (Wajib)</label><input class="modal-input" id="input-deadline" type="datetime-local"></div>
                <div>
                    <label class="modal-label" style="display:flex; align-items:center; gap:6px;">
                        <i class="fa-regular fa-eye" style="color:var(--edunotes-blue);"></i> Deskripsi <span style="font-weight:400; color:#555;">(opsional)</span>
                    </label>
                    <textarea class="modal-input" id="input-deskripsi" rows="3" placeholder="Catatan tambahan, referensi, atau detail tugas..." style="resize:vertical; min-height:80px; font-family:'Inter',sans-serif;"></textarea>
                </div>
                <div style="display:flex; gap:12px; margin-top:10px;">
                    <button onclick="toggleModal()" style="flex:1; background:transparent; border:1px solid #444; color:var(--text-muted); padding:12px; border-radius:10px; cursor:pointer; font-weight:600;">Batal</button>
                    <button onclick="simpanTugas()" style="flex:2; background:var(--edunotes-blue); border:none; color:#fff; padding:12px; border-radius:10px; cursor:pointer; font-weight:700;">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalPassword" onclick="if(event.target.id === 'modalPassword') toggleModalPassword()">
        <div class="modal-window">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700; color:#fff;"><i class="fa-solid fa-lock" style="color:var(--edunotes-blue); margin-right:8px;"></i>Ubah Password</h2>
                <i class="fa-solid fa-xmark" onclick="toggleModalPassword()" style="cursor:pointer; color:var(--text-muted); font-size:18px;"></i>
            </div>
            <div style="display:flex; flex-direction:column; gap:18px;">
                <div>
                    <label class="modal-label">Password Lama</label>
                    <input class="modal-input" id="input-pass-lama" type="password" placeholder="Masukkan password saat ini">
                </div>
                <div>
                    <label class="modal-label">Password Baru</label>
                    <input class="modal-input" id="input-pass-baru" type="password" placeholder="Masukkan password baru">
                </div>
                <div>
                    <label class="modal-label">Konfirmasi Password Baru</label>
                    <input class="modal-input" id="input-pass-konfirm" type="password" placeholder="Ketik ulang password baru">
                </div>
                <div style="display:flex; gap:12px; margin-top:10px;">
                    <button onclick="toggleModalPassword()" style="flex:1; background:transparent; border:1px solid #444; color:var(--text-muted); padding:12px; border-radius:10px; cursor:pointer; font-weight:600;">Batal</button>
                    <button onclick="prosesUbahPassword()" style="flex:2; background:var(--urgent-red); border:none; color:#fff; padding:12px; border-radius:10px; cursor:pointer; font-weight:700;">Konfirmasi Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalConfirm" onclick="if(event.target.id === 'modalConfirm') closeConfirmModal()">
        <div class="modal-window" style="width: 400px; text-align: center;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px; color: var(--urgent-red); margin-bottom: 16px;"></i>
            <h2 style="font-size:20px; font-weight:700; color:#fff; margin-bottom:8px;" id="confirm-title">Peringatan</h2>
            <p style="font-size:14px; color:var(--text-muted); margin-bottom:24px;" id="confirm-msg">Apakah Anda yakin?</p>
            <div style="display:flex; gap:12px;">
                <button onclick="closeConfirmModal()" style="flex:1; background:transparent; border:1px solid #444; color:var(--text-muted); padding:12px; border-radius:10px; cursor:pointer; font-weight:600;">Batal</button>
                <button id="btn-confirm-action" style="flex:1; background:var(--urgent-red); border:none; color:#fff; padding:12px; border-radius:10px; cursor:pointer; font-weight:700;">Konfirmasi</button>
            </div>
        </div>
    </div>

    <div id="toastNotif" class="toast">
        <i class="fa-solid fa-circle-check" id="toastIcon"></i> <span id="toastText">Aksi berhasil!</span>
    </div>

</x-layout.user>