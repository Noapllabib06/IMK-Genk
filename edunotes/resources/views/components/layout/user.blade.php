<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EduNOTES - Dashboard' }}</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--bg-dark); color: var(--text-main); font-family: 'Inter', sans-serif;">

<div class="app-container" id="appContainer">

    <aside class="sidebar">
        <div class="logo"><i class="fa-solid fa-bolt"></i> EduNOTES</div>
        <nav class="nav-menu">
            <div class="nav-item active" id="nav-dashboard" onclick="showPage('dashboard')">
                <i class="fa-solid fa-border-all"></i> <span class="i18n" data-id="Dasbor Saya" data-en="My Dashboard">Dasbor Saya</span>
            </div>
            <div class="nav-item" id="nav-calendar" onclick="showPage('calendar')">
                <i class="fa-regular fa-calendar"></i> <span class="i18n" data-id="Kalender" data-en="Calendar">Kalender</span>
            </div>
            <div class="nav-item" id="nav-history" onclick="showPage('history')">
                <i class="fa-solid fa-clock-rotate-left"></i> <span class="i18n" data-id="Riwayat" data-en="History">Riwayat</span>
            </div>
        </nav>
        
        <div style="margin-top: auto; padding-top: 16px; border-top: 1px solid #333;">
            <div class="nav-item" id="nav-account" onclick="showPage('account')">
                <i class="fa-regular fa-user"></i> <span class="i18n" data-id="Akun" data-en="Account">Akun</span>
            </div>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
            
            <div class="nav-item" style="color: var(--urgent-red); margin-top: 8px;" onclick="konfirmasiLogout()">
                <i class="fa-solid fa-right-from-bracket"></i> <span class="i18n" data-id="Keluar" data-en="Logout">Keluar</span>
            </div>
        </div>
    </aside>

    <main class="main-content">
        {{ $slot }}
    </main>

    <aside class="ai-panel">
        <div style="padding: 24px; border-bottom: 1px solid #333; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 700; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-wand-magic-sparkles" style="color:var(--normal-teal)"></i> 
                <span class="i18n" data-id="Asisten AI" data-en="AI Assistant">Asisten AI</span>
            </div>
            <i class="fa-solid fa-xmark" style="cursor:pointer; color:var(--text-muted);" onclick="toggleAIPanel()"></i>
        </div>
        <div id="ai-panel-body" style="padding: 24px; overflow-y: auto; display:flex; flex-direction:column; gap:16px;">
        </div>
    </aside>

</div>

<div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
    <div class="modal-window">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <h2 style="font-size:18px; font-weight:700; color:#fff;">
                <i class="fa-solid fa-plus" style="color:var(--edunotes-blue); margin-right:8px;"></i>
                <span class="i18n" data-id="Tambah Tugas Baru" data-en="Add New Task">Tambah Tugas Baru</span>
            </h2>
            <i class="fa-solid fa-xmark" onclick="toggleModal()" style="cursor:pointer; color:var(--text-muted); font-size:18px;"></i>
        </div>
        <div style="display:flex; flex-direction:column; gap:18px;">
            <div>
                <label class="modal-label i18n" data-id="Judul Tugas" data-en="Task Title">Judul Tugas</label>
                <input class="modal-input" id="input-judul" type="text" placeholder="Contoh: Laporan IMK">
            </div>
            <div>
                <label class="modal-label i18n" data-id="Mata Kuliah" data-en="Course">Mata Kuliah</label>
                <input class="modal-input" id="input-mapel" type="text" placeholder="Contoh: Desain Pengalaman Pengguna">
            </div>
            <div>
                <label class="modal-label i18n" data-id="Deadline & Jam (Wajib)" data-en="Deadline & Time (Required)">Deadline & Jam (Wajib)</label>
                <input class="modal-input" id="input-deadline" type="datetime-local">
            </div>
            <div>
                <label class="modal-label" style="display:flex; align-items:center; gap:6px;">
                    <i class="fa-regular fa-eye" style="color:var(--edunotes-blue);"></i> 
                    <span class="i18n" data-id="Deskripsi" data-en="Description">Deskripsi</span> 
                    <span style="font-weight:400; color:#555;" class="i18n" data-id="(opsional)" data-en="(optional)">(opsional)</span>
                </label>
                <textarea class="modal-input" id="input-deskripsi" rows="3" placeholder="Catatan tambahan, referensi, atau detail tugas..." style="resize:vertical; min-height:80px; font-family:'Inter',sans-serif;"></textarea>
            </div>
            <div style="display:flex; gap:12px; margin-top:10px;">
                <button onclick="toggleModal()" class="i18n" data-id="Batal" data-en="Cancel" style="flex:1; background:transparent; border:1px solid #444; color:var(--text-muted); padding:12px; border-radius:10px; cursor:pointer; font-weight:600;">Batal</button>
                <button onclick="simpanTugas()" class="i18n" data-id="Simpan" data-en="Save" style="flex:2; background:var(--edunotes-blue); border:none; color:#fff; padding:12px; border-radius:10px; cursor:pointer; font-weight:700;">Simpan</button>
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

<script>
    const NAMA_USER_LARAVEL = "{{ Auth::user()->name ?? 'Mahasiswa' }}";
    const EMAIL_USER_LARAVEL = "{{ Auth::user()->email ?? 'mahasiswa@kampus.id' }}";

    // --- HELPER: FORMAT WAKTU (Otomatis 24H atau 12H) ---
    function formatWaktu(jamStr) {
        if (!jamStr) return "";
        if (currentLang === 'ID') return jamStr; // Jika ID, biarkan 24 Jam
        
        let [hour, minute] = jamStr.split(':');
        let h = parseInt(hour, 10);
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12; 
        h = h ? h : 12; // Jika jam 0, ubah jadi 12
        return `${h}:${minute} ${ampm}`;
    }

    // --- FITUR: SEARCH ---
    function handleSearch(query) {
        const q = query.toLowerCase().trim();
        document.querySelectorAll('#task-grid-dashboard .task-card').forEach(card => {
            const judul = card.querySelector('h3')?.innerText.toLowerCase() || '';
            const mapel = card.querySelector('p')?.innerText.toLowerCase() || '';
            card.style.display = (judul.includes(q) || mapel.includes(q)) ? '' : 'none';
        });
    }

    // --- FITUR: LANGUAGE TOGGLE ---
    let currentLang = 'ID';
    const i18n = {
        'Dasbor Saya':        { en: 'My Dashboard' },
        'Kalender':           { en: 'Calendar' },
        'Riwayat':            { en: 'History' },
        'Account':            { en: 'Account' },
        'Riwayat Tugas':      { en: 'Task History' },
        'Progres Mingguan':   { en: 'Weekly Progress' },
        'Tugas Selesai':      { en: 'Tasks Completed' },
        'Tidak ada tugas pada kategori ini.' : { en: 'No tasks in this category.' },
    };
    function toggleLang() {
        currentLang = currentLang === 'ID' ? 'EN' : 'ID';
        document.getElementById('lang-label').innerText = currentLang;

        document.querySelectorAll('.i18n').forEach(el => {
            el.innerText = currentLang === 'EN' ? el.dataset.en : el.dataset.id;
        });

        const searchInput = document.getElementById('search-input');
        if (searchInput) searchInput.placeholder = currentLang === 'EN' ? 'Search tasks...' : 'Cari tugas...';
        const inputJudul = document.getElementById('input-judul');
        if (inputJudul) inputJudul.placeholder = currentLang === 'EN' ? 'Example: assignment report' : 'Contoh: Laporan IMK';
        const inputMapel = document.getElementById('input-mapel');
        if (inputMapel) inputMapel.placeholder = currentLang === 'EN' ? 'Example: User Experience Design' : 'Contoh: Desain Pengalaman Pengguna';
        const inputDesc = document.getElementById('input-deskripsi');
        if (inputDesc) inputDesc.placeholder = currentLang === 'EN' ? 'Additional notes, references, or task details...' : 'Catatan tambahan, referensi, atau detail tugas...';

        // Paksa render ulang agar format jam ikut berubah seketika!
        renderDashboard();
        renderCalendar();
        renderHistory();
        renderAIPanel();
        document.getElementById('agenda-panel').style.display = 'none';

        const activePage = document.querySelector('.nav-item.active').id.replace('nav-', '');
        showPage(activePage); 

        showToast(currentLang === 'EN' ? 'Language: English' : 'Bahasa: Indonesia', 'var(--normal-teal)');
    }
    
    let allTasks = [];
    const HARI_INI = new Date(); 

    // NAVIGASI
    function showPage(pageId) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('page-' + pageId).classList.add('active');
        
        const titles = { 
            dashboard: currentLang === 'ID' ? 'Dasbor Saya' : 'My Dashboard', 
            calendar: currentLang === 'ID' ? `Kalender - ${NAMA_BULAN.ID[calMonth]} ${calYear}` : `Calendar - ${NAMA_BULAN.EN[calMonth]} ${calYear}`, 
            history: currentLang === 'ID' ? 'Riwayat Tugas' : 'Task History', 
            account: currentLang === 'ID' ? 'Akun' : 'Account' 
        };
        
        document.getElementById('mainTitle').innerText = titles[pageId];
        document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
        document.getElementById('nav-' + pageId).classList.add('active');
        
        if (pageId === 'calendar') renderCalendar();
        if (pageId === 'history') renderHistory();
        if (pageId === 'dashboard') renderDashboard();
    }

    // LOGIKA URGENSI (Sudah menggunakan formatWaktu)
    function hitungUrgensi(deadlineStr, jamStr) {
        const d = new Date(`${deadlineStr}T${jamStr}`);
        const diffMinutes = (d.getTime() - HARI_INI.getTime()) / (1000 * 60);
        const diffHours = diffMinutes / 60;
        let urg = { kelas: 'normal', warna: 'var(--normal-teal)', label: '' };
        
        const isToday = d.toDateString() === HARI_INI.toDateString();
        const besok = new Date(HARI_INI); besok.setDate(HARI_INI.getDate() + 1);
        const isTomorrow = d.toDateString() === besok.toDateString();

        // Variabel penentu AM/PM atau 24 Jam
        const jamFormat = formatWaktu(jamStr); 

        if (diffHours < 0) {
            urg = { kelas: 'terlewat', warna: 'var(--warning-yellow)', label: currentLang === 'ID' ? 'TERLEWAT' : 'OVERDUE' };
        } else if (isToday) {
            urg.kelas = 'urgent'; urg.warna = 'var(--urgent-red)';
            urg.label = diffMinutes <= 120 
                ? `${Math.ceil(diffMinutes)} ${currentLang === 'ID' ? 'MENIT LAGI' : 'MINS LEFT'}` 
                : `${currentLang === 'ID' ? 'HARI INI' : 'TODAY'}, ${jamFormat}`;
        } else if (isTomorrow) {
            urg.kelas = 'warning'; urg.warna = 'var(--warning-yellow)'; 
            urg.label = `${currentLang === 'ID' ? 'BESOK' : 'TOMORROW'}, ${jamFormat}`;
        } else if (diffHours <= 168) {
            urg.kelas = 'warning'; urg.warna = 'var(--warning-yellow)';
            urg.label = `${NAMA_HARI[currentLang][d.getDay()]}, ${jamFormat}`;
        } else if (diffHours <= 336) {
            urg.kelas = 'normal'; urg.warna = 'var(--normal-teal)';
            const dObj = new Date(`${deadlineStr}T00:00:00`);
            urg.label = dObj.toLocaleDateString(currentLang === 'ID' ? 'id-ID' : 'en-US', {day: 'numeric', month: 'short'});
        } else {
            urg.kelas = 'normal'; urg.warna = 'var(--normal-teal)';
            const TahunDepan = new Date(`${deadlineStr}T00:00:00`);
            urg.label = TahunDepan.toLocaleDateString(currentLang === 'ID' ? 'id-ID' : 'en-US', {year: 'numeric'});
        }
        return urg;
    }

    function periksaTugasTerlewat() {
        allTasks.forEach(t => {
            if (t.status === 'aktif') {
                const waktuTugas = new Date(`${t.deadline}T${t.jam}`);
                if (waktuTugas < HARI_INI) { t.status = 'terlewat'; t.actionDate = 'Otomatis Sistem'; }
            }
        });
    }

    function urutkanTugas() {
        allTasks.sort((a, b) => {
            const urgA = hitungUrgensi(a.deadline, a.jam);
            const urgB = hitungUrgensi(b.deadline, b.jam);
            const weight = { 'urgent': 0, 'warning': 1, 'normal': 2, 'terlewat': 3 };
            if (weight[urgA.kelas] !== weight[urgB.kelas]) return weight[urgA.kelas] - weight[urgB.kelas];
            return new Date(`${a.deadline}T${a.jam}`).getTime() - new Date(`${b.deadline}T${b.jam}`).getTime();
        });
    }

    function updateStatusTugas(id, statusBaru) {
        const index = allTasks.findIndex(t => t.id === id);
        if(index > -1) {
            allTasks[index].status = statusBaru;
            allTasks[index].actionDate = new Date(HARI_INI).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
            periksaTugasTerlewat(); renderDashboard(); renderCalendar(); renderHistory();
            showToast(statusBaru === 'selesai' ? "Tugas Selesai!" : "Tugas Dihapus", statusBaru === 'selesai' ? "var(--normal-teal)" : "var(--urgent-red)");
        }
    }

    // SIMPAN TUGAS (Sudah fix membaca input datetime-local)
    function simpanTugas() {
        const judul = document.getElementById('input-judul').value.trim();
        const mapel = document.getElementById('input-mapel').value.trim() || 'Tanpa Kategori';
        
        const inputTgl = document.getElementById('input-deadline').value; 
        const deskripsi = document.getElementById('input-deskripsi').value.trim();
        
        if (!judul || !inputTgl) {
            showToast(currentLang === 'ID' ? "Harap isi Judul & Deadline!" : "Please fill Title & Deadline!", "var(--warning-yellow)");
            return;
        }

        const split = inputTgl.split('T');
        const tglPart = split[0];
        const jamPart = split[1] || "23:59";
        
        allTasks.push({ 
            id: Date.now(), 
            judul, 
            mapel, 
            deadline: tglPart, 
            jam: jamPart, 
            deskripsi, 
            status: "aktif" 
        });
        
        urutkanTugas(); periksaTugasTerlewat(); renderDashboard(); renderCalendar(); toggleModal();
        
        document.getElementById('input-judul').value = '';
        document.getElementById('input-mapel').value = '';
        document.getElementById('input-deadline').value = '';
        document.getElementById('input-deskripsi').value = '';
        
        showToast(currentLang === 'ID' ? "Tugas Baru Berhasil Disimpan!" : "New Task Saved Successfully!", "var(--normal-teal)");
    }

    // RENDER DASHBOARD
    function renderDashboard() {
        urutkanTugas();
        const grid = document.getElementById('task-grid-dashboard');
        grid.innerHTML = '';
        
        let aktif = allTasks.filter(t => t.status === 'aktif');
        let selesai = allTasks.filter(t => t.status === 'selesai');
        let terlewat = allTasks.filter(t => t.status === 'terlewat');
        
        let totalValid = aktif.length + selesai.length + terlewat.length;
        let pCent = totalValid === 0 ? 0 : Math.round((selesai.length / totalValid) * 100);

        document.getElementById('progress-percent').innerText = `${pCent}%`;
        document.querySelector('.progress-widget h3').innerText = currentLang === 'ID' ? 'Progres Mingguan' : 'Weekly Progress';
        document.getElementById('progress-text').innerText = currentLang === 'ID' 
            ? `${selesai.length} dari ${totalValid} Tugas Selesai`
            : `${selesai.length} of ${totalValid} Tasks Completed`;

        document.getElementById('progress-circle-bar').style.background = `conic-gradient(var(--normal-teal) ${pCent}%, #333 ${pCent}%)`;

        aktif.forEach(t => {
            const urg = hitungUrgensi(t.deadline, t.jam);
            const titleEye = currentLang === 'ID' ? 'Lihat Deskripsi' : 'View Description';
            const deskripsiHtml = t.deskripsi
                ? `<div id="desc-${t.id}" style="display:none; margin-top:12px; padding:10px 14px; background:rgba(255,255,255,0.03); border-left:2px solid #444; border-radius:6px; font-size:13px; color:var(--text-muted); line-height:1.6;">${t.deskripsi}</div>`
                : '';
            grid.innerHTML += `
                <div class="task-card ${urg.kelas}">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div style="flex:1; min-width:0;">
                            <h3 style="font-size:15px; font-weight:700; color:#fff; margin-bottom:4px;">${t.judul}</h3>
                            <p style="color:var(--text-muted); font-size:13px; margin-bottom:12px;">${t.mapel}</p>
                            <span class="badge" style="color:${urg.warna}; border: 1px solid ${urg.warna}40;">${urg.label}</span>
                            ${deskripsiHtml}
                        </div>
                        <div class="task-actions">
                            ${t.deskripsi ? `<i class="fa-regular fa-eye action-icon eye-desc" title="${titleEye}" onclick="toggleDeskripsi(${t.id}, this)"></i>` : ''}
                            <i class="fa-solid fa-check action-icon check" onclick="updateStatusTugas(${t.id}, 'selesai')"></i>
                            <i class="fa-solid fa-trash action-icon trash" onclick="updateStatusTugas(${t.id}, 'dihapus')"></i>
                        </div>
                    </div>
                </div>`;
        });
    }

    const _now   = new Date();
    let calYear  = _now.getFullYear();
    let calMonth = _now.getMonth();
    const NAMA_BULAN = {
        ID: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        EN: ['January','February','March','April','May','June','July','August','September','October','November','December']
    };
    const NAMA_HARI = {
        ID: ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'],
        EN: ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY']
    };

    function gantibulan(arah) {
        document.getElementById('agenda-panel').style.display = 'none';
        calMonth += arah;
        if (calMonth > 11) { calMonth = 0; calYear++; }
        if (calMonth < 0)  { calMonth = 11; calYear--; }
        document.getElementById('mainTitle').innerText = currentLang === 'ID' 
            ? `Kalender - ${NAMA_BULAN.ID[calMonth]} ${calYear}` 
            : `Calendar - ${NAMA_BULAN.EN[calMonth]} ${calYear}`;
        renderCalendar();
    }

    function renderCalendar() {
        const grid = document.getElementById('calendar-grid');
        grid.innerHTML = '';
        document.getElementById('cal-month-label').innerText = `${NAMA_BULAN[currentLang][calMonth]} ${calYear}`;
        
        const daysHeader = currentLang === 'ID' 
            ? '<div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>'
            : '<div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>';
        grid.previousElementSibling.innerHTML = daysHeader;

        const hariPertama = new Date(calYear, calMonth, 1).getDay();
        const totalHari   = new Date(calYear, calMonth + 1, 0).getDate();
        for (let i = 0; i < hariPertama; i++) grid.innerHTML += '<div></div>';
        for (let d = 1; d <= totalHari; d++) {
            const mm      = String(calMonth + 1).padStart(2, '0');
            const dd      = String(d).padStart(2, '0');
            const dateStr = `${calYear}-${mm}-${dd}`;
            const isToday = (d === HARI_INI.getDate() && calMonth === HARI_INI.getMonth() && calYear === HARI_INI.getFullYear());
            let dayHtml = `<div class="cal-day ${isToday ? 'today' : ''}" onclick="lihatAgendaTanggal('${dateStr}')"><div class="cal-day-num">${d}</div>`;
            allTasks.filter(t => t.status === 'aktif' && t.deadline === dateStr).forEach(t => {
                const urg = hitungUrgensi(t.deadline, t.jam);
                dayHtml += `<span class="cal-task-label" style="color:${urg.warna}; border-left:2px solid ${urg.warna}">${t.judul}</span>`;
            });
            grid.innerHTML += dayHtml + `</div>`;
        }
    }

    function lihatAgendaTanggal(dateStr) {
        document.querySelectorAll('.cal-day').forEach(el => el.classList.remove('selected'));
        const panel = document.getElementById('agenda-panel'); 
        const grid = document.getElementById('agenda-task-grid');
        const tasksOnDate = allTasks.filter(t => t.deadline === dateStr);
        
        const locale = currentLang === 'ID' ? 'id-ID' : 'en-US';
        document.getElementById('agenda-date').innerText = new Date(dateStr).toLocaleDateString(locale, {weekday:'long', day:'numeric', month:'long'});
        
        grid.innerHTML = '';
        if (tasksOnDate.length === 0) {
            const emptyText = currentLang === 'ID' ? 'Tidak ada agenda.' : 'No agenda for this date.';
            grid.innerHTML = `<p style="color:var(--text-muted); font-size:14px; font-style:italic;">${emptyText}</p>`;
        } else {
            tasksOnDate.forEach(t => {
                const urg = hitungUrgensi(t.deadline, t.jam);
                const dispMapel = (t.mapel === 'Tanpa Kategori' && currentLang === 'EN') ? 'Uncategorized' : t.mapel;
                
                let dispStatus = t.status.toUpperCase();
                if (currentLang === 'EN') {
                    if (t.status === 'selesai') dispStatus = 'COMPLETED';
                    if (t.status === 'terlewat') dispStatus = 'OVERDUE';
                    if (t.status === 'dihapus') dispStatus = 'DELETED';
                }
                
                // Terhubung ke fungsi helper formatWaktu()
                const badgeText = t.status === 'aktif' ? '⏰ ' + formatWaktu(t.jam) : dispStatus;
                
                grid.innerHTML += `
                    <div class="task-card ${t.status === 'aktif' ? urg.kelas : 'normal'}" style="padding:16px;"> 
                        <h3 style="font-size:14px; color:#fff;">${t.judul}</h3> 
                        <p style="color:var(--text-muted); font-size:12px;">${dispMapel}</p> 
                        <span class="badge" style="color:${t.status === 'aktif'? urg.warna : 'var(--text-muted)'}">${badgeText}</span> 
                    </div>`;
            });
        }
        panel.style.display = 'block';
    }

    function toggleAIPanel() {
        document.getElementById('appContainer').classList.toggle('panel-closed');
        renderAIPanel();
    }
    function toggleModal() { document.getElementById('modalOverlay').classList.toggle('show'); }
    function handleOverlayClick(e) { if (e.target.id === 'modalOverlay') toggleModal(); }

    function toggleDeskripsi(id, iconEl) {
        const panel = document.getElementById('desc-' + id);
        if (!panel) return;
        const isHidden = panel.style.display === 'none';
        panel.style.display = isHidden ? 'block' : 'none';
        iconEl.classList.toggle('desc-open', isHidden);
        iconEl.classList.toggle('fa-eye-slash', isHidden);
        iconEl.classList.toggle('fa-eye', !isHidden);
    }
    function showToast(pesan, warna) {
        const toast = document.getElementById('toastNotif'); document.getElementById('toastText').innerText = pesan;
        toast.style.background = warna; toast.classList.add('show'); setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // AI PANEL
    function renderAIPanel() {
        const body = document.getElementById('ai-panel-body');
        if (!body) return;
        body.innerHTML = '';

        const tugasAktif = allTasks.filter(t => t.status === 'aktif');
        const btnGenText = currentLang === 'ID' ? 'Generate Jadwal Optimal' : 'Generate Optimal Schedule';

        const kritis = tugasAktif.filter(t => {
            const d = new Date(`${t.deadline}T${t.jam}`);
            const diffHours = (d.getTime() - HARI_INI.getTime()) / (1000 * 60 * 60);
            return diffHours >= 0 && diffHours < 2;
        });

        if (kritis.length > 0) {
            kritis.forEach(t => {
                const d = new Date(`${t.deadline}T${t.jam}`);
                const diffMin = Math.ceil((d.getTime() - HARI_INI.getTime()) / (1000 * 60));
                const titleCrit = currentLang === 'ID' ? 'TENGGAT KRITIS!' : 'CRITICAL DEADLINE!';
                const minText = currentLang === 'ID' ? 'menit lagi' : 'mins left';
                const dispMapel = (t.mapel === 'Tanpa Kategori' && currentLang === 'EN') ? 'Uncategorized' : t.mapel;
                
                body.innerHTML += `
                    <div class="suggestion-box" style="border-left: 3px solid var(--urgent-red); animation: fadeIn 0.3s ease;">
                        <h4 style="font-size:13px; margin-bottom:6px; color:var(--urgent-red); display:flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-triangle-exclamation"></i> ${titleCrit}
                        </h4>
                        <p style="font-size:13px; color:#fff; font-weight:700; margin-bottom:4px;">${t.judul}</p>
                        <p style="font-size:12px; color:var(--text-muted); line-height:1.5; margin-bottom:6px;">${dispMapel}</p>
                        <span style="font-size:11px; font-weight:800; color:var(--urgent-red); background:rgba(255,71,87,0.1); padding:3px 8px; border-radius:4px;">
                            ⏰ ${diffMin} ${minText}
                        </span>
                    </div>`;
            });
        } else if (tugasAktif.length === 0) {
            const emptyText = currentLang === 'ID' ? 'Tidak ada tugas aktif.<br>Santai dulu! ☕' : 'No active tasks.<br>Relax! ☕';
            body.innerHTML += `
                <div style="text-align:center; padding:32px 0; color:var(--text-muted);">
                    <i class="fa-solid fa-mug-hot" style="font-size:36px; margin-bottom:12px; display:block; opacity:0.4;"></i>
                    <p style="font-size:13px; line-height:1.6;">${emptyText}</p>
                </div>`;
        } else {
            const terdekat = [...tugasAktif].sort((a,b) =>
                new Date(`${a.deadline}T${a.jam}`) - new Date(`${b.deadline}T${b.jam}`)
            )[0];
            const urg = hitungUrgensi(terdekat.deadline, terdekat.jam);
            const focusText = currentLang === 'ID' ? 'Fokus Berikutnya' : 'Next Focus';
            const dispMapel = (terdekat.mapel === 'Tanpa Kategori' && currentLang === 'EN') ? 'Uncategorized' : terdekat.mapel;
            
            body.innerHTML += `
                <div class="suggestion-box" style="border-left: 3px solid var(--warning-yellow);">
                    <h4 style="font-size:13px; margin-bottom:6px; color:var(--warning-yellow); display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-bell"></i> ${focusText}
                    </h4>
                    <p style="font-size:13px; color:#fff; font-weight:700; margin-bottom:4px;">${terdekat.judul}</p>
                    <p style="font-size:12px; color:var(--text-muted); margin-bottom:6px;">${dispMapel}</p>
                    <span style="font-size:11px; font-weight:800; color:${urg.warna}; background:${urg.warna}1a; padding:3px 8px; border-radius:4px;">
                        ${urg.label}
                    </span>
                </div>`;
        }

        body.innerHTML += `
            <button onclick="generateJadwalAI()" style="width:100%; background:#2a2a2a; color:#fff; border:1px solid #444; padding:12px; border-radius:8px; cursor:pointer; font-weight:600; margin-top:4px;">
                <i class="fa-solid fa-bolt" style="color:#fff; margin-right:4px;"></i> ${btnGenText}
            </button>`;
    }

    function generateJadwalAI() {
        const aiContainer = document.querySelector('.ai-panel > div:nth-child(2)');
        let tugasAktif = allTasks.filter(t => t.status === 'aktif');
        
        if (tugasAktif.length === 0) {
            showToast(currentLang === 'ID' ? "Tidak ada tugas aktif untuk dijadwalkan!" : "No active tasks to schedule!", "var(--warning-yellow)");
            return;
        }

        tugasAktif.sort((a, b) => new Date(`${a.deadline}T${a.jam}`) - new Date(`${b.deadline}T${b.jam}`));

        const titleText = currentLang === 'ID' ? 'Rundown Disarankan:' : 'Suggested Rundown:';
        const courseText = currentLang === 'ID' ? 'Mata Kuliah:' : 'Course:';
        const dueText = currentLang === 'ID' ? 'Batas Waktu:' : 'Deadline:';
        const regenText = currentLang === 'ID' ? 'Regenerate Jadwal' : 'Regenerate Schedule';

        let rundownHTML = `
            <div class="suggestion-box" style="border-left: 3px solid var(--edunotes-blue);">
                <h4 style="font-size:14px; margin-bottom:10px;"><i class="fa-solid fa-list-check" style="color:var(--edunotes-blue); margin-right:4px;"></i> ${titleText}</h4>
                <ul style="font-size:13px; color:var(--text-muted); line-height:1.6; padding-left:16px;">
        `;
                
       tugasAktif.slice(0, 3).forEach((t, index) => {
            const dispMapel = (t.mapel === 'Tanpa Kategori' && currentLang === 'EN') ? 'Uncategorized' : t.mapel;
            const atText = currentLang === 'ID' ? 'pukul' : 'at';
            const locale = currentLang === 'ID' ? 'id-ID' : 'en-US';
            const dObj = new Date(`${t.deadline}T00:00:00`);
            const formattedDate = dObj.toLocaleDateString(locale, { day: 'numeric', month: 'long', year: 'numeric' });
            
            // Terhubung ke fungsi helper formatWaktu()
            let formattedTime = formatWaktu(t.jam); 

            rundownHTML += `
                <li style="margin-bottom:8px;">
                    <strong style="color:#fff">${t.judul}</strong><br>
                    ${courseText} ${dispMapel}<br>
                    ${dueText} ${formattedDate} ${atText} ${formattedTime}
                </li>`;
        });
        rundownHTML += `</ul></div>`;
        
        const btnHtml = `
            <button onclick="generateJadwalAI()" style="width:100%; background:#2a2a2a; color:#fff; border:1px solid #444; padding:12px; border-radius:8px; cursor:pointer; font-weight:600;">
                <i class="fa-solid fa-rotate-right" style="color:#fff; margin-right:4px;"></i> ${regenText}
            </button>
        `;
        
        aiContainer.innerHTML = rundownHTML + btnHtml;
        showToast(currentLang === 'ID' ? "Jadwal optimal berhasil dibuat!" : "Optimal schedule generated!", "var(--normal-teal)");
    }

    // FILTER RIWAYAT
    let filterRiwayatAktif = 'semua';
    function filterHistory(tipe) {
        filterRiwayatAktif = tipe;
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById('filter-' + tipe).classList.add('active');
        renderHistory();
    }

    function renderHistory() {
        const grid = document.getElementById('history-task-grid'); 
        grid.innerHTML = '';
        
        let riwayat = allTasks.filter(t => t.status !== 'aktif');
        if (filterRiwayatAktif !== 'semua') riwayat = riwayat.filter(t => t.status === filterRiwayatAktif);

        if (riwayat.length === 0) {
            const emptyMsg = currentLang === 'ID' ? 'Tidak ada tugas pada kategori ini.' : 'No tasks in this category.';
            grid.innerHTML = `<p style="color:var(--text-muted); font-size:14px; font-style:italic;">${emptyMsg}</p>`;
            return;
        }

        riwayat.forEach(t => {
            let sIcon = t.status === 'selesai' ? (currentLang === 'ID' ? '✅ Selesai' : '✅ Done') 
                      : t.status === 'terlewat' ? (currentLang === 'ID' ? '❌ Terlewat' : '❌ Overdue') 
                      : (currentLang === 'ID' ? '🗑️ Dihapus' : '🗑️ Deleted');
            let sColor = t.status === 'selesai' ? 'var(--normal-teal)' : t.status === 'terlewat' ? 'var(--warning-yellow)' : '#555';
            let tanggalAksi = t.actionDate ? t.actionDate : '-';

            grid.innerHTML += `
                <div class="task-card normal" style="opacity: ${t.status==='dihapus'?0.5 : 0.8}">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <h3 style="font-size:15px; color:#fff; text-decoration: ${t.status==='selesai'||t.status==='dihapus' ? 'line-through': 'none'};">${t.judul}</h3>
                            <p style="color:var(--text-muted); font-size:13px; margin-bottom:10px;">${t.mapel}</p>
                            <span class="badge" style="color:var(--text-muted)">${currentLang === 'ID' ? 'Aksi:' : 'Action:'} ${tanggalAksi}</span>
                        </div>
                        <span class="status-badge" style="color:${sColor}; background:rgba(255,255,255,0.05); padding: 4px 10px;">${sIcon}</span>
                    </div>
                </div>`;
        });
    }

    // UBAH PASSWORD
    function toggleModalPassword() {
        const modal = document.getElementById('modalPassword');
        modal.classList.toggle('show');
        if (!modal.classList.contains('show')) {
            document.getElementById('input-pass-lama').value = '';
            document.getElementById('input-pass-baru').value = '';
            document.getElementById('input-pass-konfirm').value = '';
        }
    }

    function prosesUbahPassword() {
        const pLama = document.getElementById('input-pass-lama').value;
        const pBaru = document.getElementById('input-pass-baru').value;
        const pKonfirm = document.getElementById('input-pass-konfirm').value;

        if (!pLama || !pBaru || !pKonfirm) { showToast("Semua kolom harus diisi!", "var(--warning-yellow)"); return; }
        if (pBaru !== pKonfirm) { showToast("Konfirmasi password tidak cocok!", "var(--urgent-red)"); return; }

        toggleModalPassword(); showToast("Password Berhasil Diubah", "var(--normal-teal)");
    }

    // --- FITUR KONFIRMASI LOGOUT ---
    let aksiKonfirmasi = null;
    function openConfirmModal(judul, pesan, callback) {
        document.getElementById('confirm-title').innerText = judul;
        document.getElementById('confirm-msg').innerText = pesan;
        aksiKonfirmasi = callback;
        document.getElementById('modalConfirm').classList.add('show');
    }

    function closeConfirmModal() { document.getElementById('modalConfirm').classList.remove('show'); aksiKonfirmasi = null; }

    document.getElementById('btn-confirm-action').addEventListener('click', function() {
        if (aksiKonfirmasi) aksiKonfirmasi(); closeConfirmModal();
    });

    function konfirmasiLogout() {
        const judulKonfirm = currentLang === 'ID' ? "Konfirmasi Keluar" : "Logout Confirmation";
        const pesanKonfirm = currentLang === 'ID' ? "Apakah Anda yakin ingin keluar dari EduNOTES?" : "Are you sure you want to log out of EduNOTES?";
        openConfirmModal(judulKonfirm, pesanKonfirm, function() {
            document.getElementById('logout-form').submit();
        });
    }

    function hapusSemuaTugas() {
        openConfirmModal("Hapus Semua Tugas", "Apakah Anda yakin ingin menghapus seluruh tugas?", function() {
            const tanggalAksi = new Date(HARI_INI).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
            allTasks.forEach(t => { if (t.status !== 'dihapus') { t.status = 'dihapus'; t.actionDate = tanggalAksi; } });
            renderDashboard(); renderCalendar(); renderHistory(); 
            showToast("Seluruh tugas dipindahkan ke Riwayat", "var(--urgent-red)");
        });
    }

    function toggleEditProfil() {
        const inputs = [document.getElementById('prof-nama'), document.getElementById('prof-email'), document.getElementById('prof-jurusan')];
        const btn = document.getElementById('btn-edit-profil');
        const isRead = inputs[0].hasAttribute('readonly');
        
        const textEdit = currentLang === 'ID' ? 'Edit Profil' : 'Edit Profile';
        const textSave = currentLang === 'ID' ? 'Simpan Profil' : 'Save Profile';

        if(isRead) {
            inputs.forEach(i => i.removeAttribute('readonly')); inputs[0].focus();
            btn.innerHTML = `<i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> <span id="text-edit-profil" class="i18n" data-id="Simpan Profil" data-en="Save Profile">${textSave}</span>`;
            btn.style.background = 'var(--normal-teal)'; btn.style.color = '#000';
        } else {
            inputs.forEach(i => i.setAttribute('readonly', true));
            btn.innerHTML = `<i class="fa-solid fa-pen" style="margin-right:6px;"></i> <span id="text-edit-profil" class="i18n" data-id="Edit Profil" data-en="Edit Profile">${textEdit}</span>`;
            btn.style.background = 'var(--edunotes-blue)'; btn.style.color = '#fff';
            
            document.getElementById('disp-name').innerText = inputs[0].value;
            document.getElementById('disp-email').innerText = inputs[1].value;
            showToast('Profil diperbarui!', 'var(--normal-teal)');
        }
    }

    function toggleNotif(el) { el.classList.toggle('on'); showToast('Pengaturan disimpan', 'var(--normal-teal)'); }

    // INISIALISASI
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('disp-name').innerText = NAMA_USER_LARAVEL;
        document.getElementById('disp-email').innerText = EMAIL_USER_LARAVEL;
        document.getElementById('prof-nama').value = NAMA_USER_LARAVEL;
        document.getElementById('prof-email').value = EMAIL_USER_LARAVEL;
        
        periksaTugasTerlewat(); renderDashboard(); renderAIPanel();
    });
</script>