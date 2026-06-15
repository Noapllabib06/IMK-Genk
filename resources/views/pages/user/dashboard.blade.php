<x-layout.user>
    <x-slot:title>EduNOTES - Dashboard & Task Manager</x-slot:title>

    <header class="header">
        <h1 class="page-title" id="mainTitle">Dasbor Saya</h1>
        <div style="display: flex; gap: 3px; align-items: center;">

            <div id="search-wrapper" style="display:flex; align-items:center; background:#2a2a2a; border:1px solid #444; border-radius:30px; padding:0 16px; height:44px; gap:8px; transition:0.3s cubic-bezier(0.4, 0, 0.2, 1); width:200px; overflow:hidden;"
                onfocusin="this.style.width='280px'; this.style.borderColor='var(--edunotes-blue)';" 
                onfocusout="this.style.width='200px'; this.style.borderColor='#444';">
                <i class="fa-solid fa-magnifying-glass" style="color:var(--text-muted); flex-shrink:0;"></i>
                <input id="search-input" type="text" placeholder="Cari tugas..." oninput="handleSearch(this.value)"
                    style="background:transparent; border:none; outline:none; color:#fff; font-family:'Inter',sans-serif; font-size:13px; width:100%; opacity:1; pointer-events:auto;">
            </div>

            <button id="btn-lang" onclick="toggleLang()"
                style="background:#2a2a2a; border:1px solid #444; border-radius:30px; padding:0 16px; height:44px; color:#fff; font-weight:700; font-size:12px; cursor:pointer; display:flex; align-items:center; gap:6px; transition:0.2s; white-space:nowrap;">
                <i class="fa-solid fa-globe" style="color:var(--normal-teal);"></i>
                <span id="lang-label">ID</span>
            </button>

            <button class="btn-quick-add" style="background: #2a2a2a; border: 1px solid #444;" onclick="toggleAIPanel()">
                <i class="fa-solid fa-robot"></i> <span class="i18n" data-id="AI Panel" data-en="AI Panel">AI Panel</span>
            </button>

            <button class="btn-quick-add" onclick="toggleModal()">
                <i class="fa-solid fa-plus"></i> <span class="i18n" data-id="Tambah Tugas Cepat" data-en="Add Task">Tambah Tugas Cepat</span>
            </button>
        </div>
    </header>

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
                </div>
            <div id="calendar-grid"></div>
        </div>
        <div id="agenda-panel" style="display: none; background: var(--card-dark); padding: 24px; border-radius: 16px; border: 1px solid #333; margin-top: 24px;">
            <h3 style="font-size:18px; margin-bottom:16px; color:#fff;">
                <span class="i18n" data-id="Agenda:" data-en="Agenda:">Agenda:</span> 
                <span id="agenda-date" style="color:var(--edunotes-blue);"></span>
            </h3>
            <div class="task-grid" id="agenda-task-grid"></div>
        </div>
    </div>

    <div id="page-history" class="page">
        <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
            <button onclick="filterHistory('semua')" class="filter-btn active" id="filter-semua">
                <span class="i18n" data-id="Semua" data-en="All">Semua</span>
            </button>
            <button onclick="filterHistory('selesai')" class="filter-btn" id="filter-selesai">
                ✅ <span class="i18n" data-id="Selesai" data-en="Completed">Selesai</span>
            </button>
            <button onclick="filterHistory('terlewat')" class="filter-btn" id="filter-terlewat">
                ❌ <span class="i18n" data-id="Terlewat" data-en="Overdue">Terlewat</span>
            </button>
            <button onclick="filterHistory('dihapus')" class="filter-btn" id="filter-dihapus">
                🗑️ <span class="i18n" data-id="Dihapus" data-en="Deleted">Dihapus</span>
            </button>
        </div>
        <div class="task-grid" id="history-task-grid"></div>
    </div>

    <div id="page-account" class="page">
        <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px 32px; margin-bottom:24px; display:flex; align-items:center; gap:24px;">
            <div style="width:72px; height:72px; border-radius:50%; background:var(--normal-teal); display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:800; color:#000; flex-shrink:0;">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div>
                <h2 style="font-size:22px; font-weight:700; color:#fff; margin-bottom:4px;" id="disp-name">Loading...</h2>
                <p style="font-size:14px; color:var(--text-muted); margin-bottom:10px;" id="disp-email">Loading...</p>
                <span style="font-size:12px; font-weight:700; padding:4px 12px; border-radius:20px; background:rgba(13,110,253,0.15); color:var(--edunotes-blue); display:inline-block;">
                    <i class="fa-solid fa-medal" style="margin-right:4px;"></i> 
                    <span class="i18n" data-id="Pengguna Terdaftar" data-en="Registered User">Pengguna Terdaftar</span>
                </span>
            </div>
        </div>

        <div class="account-grid">
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                    <h3 style="font-size:13px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">
                        <i class="fa-regular fa-user" style="margin-right:6px;"></i> <span class="i18n" data-id="Informasi Pribadi" data-en="Personal Information">Informasi Pribadi</span>
                    </h3>
                    <div class="input-group">
                        <label class="input-label i18n" data-id="Nama Lengkap" data-en="Full Name">Nama Lengkap</label>
                        <input type="text" class="input-control" id="prof-nama" value="" readonly>
                    </div>
                    <div class="input-group">
                        <label class="input-label">Email</label>
                        <input type="email" class="input-control" id="prof-email" value="" readonly>
                    </div>
                    <div class="input-group" style="margin-bottom:24px;">
                        <label class="input-label i18n" data-id="Jurusan" data-en="Major">Jurusan</label>
                        <input type="text" class="input-control" id="prof-jurusan" value="Teknik Informatika" readonly>
                    </div>
                    <button id="btn-edit-profil" onclick="toggleEditProfil()" style="width:100%; background:var(--edunotes-blue); color:#fff; border:none; padding:12px; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px; transition:0.2s;">
                        <i class="fa-solid fa-pen" style="margin-right:6px;"></i> <span id="text-edit-profil" class="i18n" data-id="Edit Profil" data-en="Edit Profile">Edit Profil</span>
                    </button>
                </div>

                <div class="danger-zone" style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                    <h3 style="color:var(--urgent-red); font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">
                        <i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i> DANGER ZONE
                    </h3>
                    <div class="sec-row">
                        <div>
                            <p style="font-size:14px; font-weight:600; color:#fff;" class="i18n" data-id="Hapus Semua Tugas" data-en="Delete All Tasks">Hapus Semua Tugas</p>
                            <p style="font-size:12px; color:var(--text-muted); margin-top:2px;" class="i18n" data-id="Tindakan ini tidak bisa dibatalkan" data-en="This action cannot be undone">Tindakan ini tidak bisa dibatalkan</p>
                        </div>
                        <button class="btn-danger-outline i18n" data-id="Hapus" data-en="Delete" onclick="hapusSemuaTugas()">Hapus</button>
                    </div>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                    <h3 style="font-size:13px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">
                        <i class="fa-solid fa-lock" style="margin-right:6px;"></i> <span class="i18n" data-id="Keamanan" data-en="Security">Keamanan</span>
                    </h3>
                    <div class="sec-row">
                        <div>
                            <p style="font-size:14px; font-weight:600; color:#fff;">Password</p>
                            <p style="font-size:12px; color:var(--text-muted); margin-top:2px;" class="i18n" data-id="Fitur Demo" data-en="Demo Feature">Fitur Demo UI</p>
                        </div>
                        <button class="btn-outline-gray i18n" data-id="Ubah" data-en="Change" onclick="toggleModalPassword()">Ubah</button>
                    </div>
                </div>

                <div style="background:var(--card-dark); border:1px solid #333; border-radius:16px; padding:24px;">
                    <h3 style="font-size:13px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">
                        <i class="fa-regular fa-bell" style="margin-right:6px;"></i> <span class="i18n" data-id="Notifikasi" data-en="Notifications">Notifikasi</span>
                    </h3>
                    <div class="sec-row">
                        <p style="font-size:14px; font-weight:600; color:#fff;" class="i18n" data-id="Pengingat deadline" data-en="Deadline reminders">Pengingat deadline</p>
                        <div onclick="toggleNotif(this)" class="toggle-switch on"><div class="knob"></div></div>
                    </div>
                    <div class="sec-row">
                        <p style="font-size:14px; font-weight:600; color:#fff;" class="i18n" data-id="Saran dari AI" data-en="AI Suggestions">Saran dari AI</p>
                        <div onclick="toggleNotif(this)" class="toggle-switch on"><div class="knob"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</x-layout.user>

