import './bootstrap';

let allTasks = [];

const HARI_INI = new Date('2026-04-05T14:00:00'); 

// NAVIGASI
function showPage(pageId) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.getElementById('page-' + pageId).classList.add('active');
    const titles = { dashboard: 'Dasbor Saya', calendar: `Kalender - ${NAMA_BULAN[calMonth]} ${calYear}`, history: 'Riwayat Tugas', account: 'Account' };
    document.getElementById('mainTitle').innerText = titles[pageId];
    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
    document.getElementById('nav-' + pageId).classList.add('active');
    
    if (pageId === 'calendar') renderCalendar();
    if (pageId === 'history') renderHistory();
    if (pageId === 'dashboard') renderDashboard();
}

// LOGIKA URGENSI (DIPERBAIKI UNTUK TANGGAL CYAN)
function hitungUrgensi(deadlineStr, jamStr) {
    const d = new Date(`${deadlineStr}T${jamStr}`);
    const diffHours = (d.getTime() - HARI_INI.getTime()) / (1000 * 60 * 60);
    let urg = { kelas: 'normal', warna: 'var(--normal-teal)', label: '' };
    
    const isToday = d.toDateString() === HARI_INI.toDateString();
    const besok = new Date(HARI_INI); besok.setDate(HARI_INI.getDate() + 1);
    const isTomorrow = d.toDateString() === besok.toDateString();

    if (diffHours < 0) {
        urg = { kelas: 'terlewat', warna: 'var(--warning-yellow)', label: 'TERLEWAT' };
    } else if (isToday) {
        urg.kelas = 'urgent'; urg.warna = 'var(--urgent-red)';
        urg.label = diffHours <= 2 ? `${Math.ceil(diffHours)} JAM LAGI` : `HARI INI, ${jamStr}`;
    } else if (isTomorrow) {
        urg.kelas = 'warning'; urg.warna = 'var(--warning-yellow)'; urg.label = `BESOK, ${jamStr}`;
    } else if (diffHours <= 168) {
        urg.kelas = 'warning'; urg.warna = 'var(--warning-yellow)';
        const namaHari = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
        urg.label = `${namaHari[d.getDay()]}, ${jamStr}`;
    } else {
        urg.kelas = 'normal'; urg.warna = 'var(--normal-teal)';
        const dObj = new Date(`${deadlineStr}T00:00:00`);
        urg.label = dObj.toLocaleDateString('id-ID', {day: 'numeric', month: 'short'});
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

function simpanTugas() {
    const judul = document.getElementById('input-judul').value.trim();
    const mapel = document.getElementById('input-mapel').value.trim() || 'Tanpa Kategori';
    const inputTgl = document.getElementById('input-deadline').value;
    const deskripsi = document.getElementById('input-deskripsi').value.trim();
    if (!judul || !inputTgl) return alert("Harap isi Judul & Deadline!");
    const split = inputTgl.split('T');
    allTasks.push({ id: Date.now(), judul, mapel, deadline: split[0], jam: split[1] || "23:59", deskripsi, status: "aktif" });
    urutkanTugas(); periksaTugasTerlewat(); renderDashboard(); renderCalendar(); toggleModal();
    document.getElementById('input-judul').value = '';
    document.getElementById('input-mapel').value = '';
    document.getElementById('input-deadline').value = '';
    document.getElementById('input-deskripsi').value = '';
    showToast("Tugas Baru Berhasil Disimpan!");
}

// RENDER DASHBOARD (DENGAN PROGRESS BAR DINAMIS)
function renderDashboard() {
    urutkanTugas();
    const grid = document.getElementById('task-grid-dashboard');
    if(!grid) return; // Mencegah error jika bukan di halaman dashboard
    grid.innerHTML = '';
    
    let aktif = allTasks.filter(t => t.status === 'aktif');
    let selesai = allTasks.filter(t => t.status === 'selesai');
    let terlewat = allTasks.filter(t => t.status === 'terlewat');
    
    let totalValid = aktif.length + selesai.length + terlewat.length;
    let pCent = totalValid === 0 ? 0 : Math.round((selesai.length / totalValid) * 100);

    const percentEl = document.getElementById('progress-percent');
    if(percentEl) percentEl.innerText = `${pCent}%`;
    const textEl = document.getElementById('progress-text');
    if(textEl) textEl.innerText = `${selesai.length} dari ${totalValid} Tugas Selesai`;
    const circleEl = document.getElementById('progress-circle-bar');
    if(circleEl) circleEl.style.background = `conic-gradient(var(--normal-teal) ${pCent}%, #333 ${pCent}%)`;

    aktif.forEach(t => {
        const urg = hitungUrgensi(t.deadline, t.jam);
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
                        ${t.deskripsi ? `<i class="fa-regular fa-eye action-icon eye-desc" title="Lihat Deskripsi" onclick="toggleDeskripsi(${t.id}, this)"></i>` : ''}
                        <i class="fa-solid fa-check action-icon check" onclick="updateStatusTugas(${t.id}, 'selesai')"></i>
                        <i class="fa-solid fa-trash action-icon trash" onclick="updateStatusTugas(${t.id}, 'dihapus')"></i>
                    </div>
                </div>
            </div>`;
    });
}

// STATE bulan aktif kalender
let calYear  = HARI_INI.getFullYear();
let calMonth = HARI_INI.getMonth();
const NAMA_BULAN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

function gantibulan(arah) {
    document.getElementById('agenda-panel').style.display = 'none';
    calMonth += arah;
    if (calMonth > 11) { calMonth = 0; calYear++; }
    if (calMonth < 0)  { calMonth = 11; calYear--; }
    document.getElementById('mainTitle').innerText = `Kalender - ${NAMA_BULAN[calMonth]} ${calYear}`;
    renderCalendar();
}

function renderCalendar() {
    const grid = document.getElementById('calendar-grid');
    if(!grid) return;
    grid.innerHTML = '';
    document.getElementById('cal-month-label').innerText = `${NAMA_BULAN[calMonth]} ${calYear}`;
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
    const panel = document.getElementById('agenda-panel'); const grid = document.getElementById('agenda-task-grid');
    const tasksOnDate = allTasks.filter(t => t.deadline === dateStr);
    document.getElementById('agenda-date').innerText = new Date(dateStr).toLocaleDateString('id-ID', {weekday:'long', day:'numeric', month:'long'});
    grid.innerHTML = '';
    if (tasksOnDate.length === 0) grid.innerHTML = `<p style="color:var(--text-muted); font-size:14px; font-style:italic;">Tidak ada agenda.</p>`;
    else tasksOnDate.forEach(t => {
        const urg = hitungUrgensi(t.deadline, t.jam);
        grid.innerHTML += `<div class="task-card ${t.status === 'aktif' ? urg.kelas : 'normal'}" style="padding:16px;"> <h3 style="font-size:14px; color:#fff;">${t.judul}</h3> <p style="color:var(--text-muted); font-size:12px;">${t.mapel}</p> <span class="badge" style="color:${t.status === 'aktif'? urg.warna : 'var(--text-muted)'}">${t.status === 'aktif'? '⏰ ' + t.jam : t.status.toUpperCase()}</span> </div>`;
    });
    panel.style.display = 'block';
}

function toggleAIPanel() { document.getElementById('appContainer').classList.toggle('panel-closed'); }
function toggleModal() { document.getElementById('modalOverlay').classList.toggle('show'); }
function handleOverlayClick(e) { if (e.target.id === 'modalOverlay') toggleModal(); }

function toggleDeskripsi(id, iconEl) {
    const panel = document.getElementById('desc-' + id);
    if (!panel) return;
    const isHidden = panel.style.display === 'none';
    panel.style.display = isHidden ? 'block' : 'none';
    iconEl.style.color = isHidden ? 'var(--edunotes-blue)' : 'var(--text-muted)';
    iconEl.classList.toggle('fa-eye-slash', isHidden);
    iconEl.classList.toggle('fa-eye', !isHidden);
}

function showToast(pesan, warna = "var(--normal-teal)") {
    const toast = document.getElementById('toastNotif'); 
    if(!toast) return;
    document.getElementById('toastText').innerText = pesan;
    toast.style.background = warna; 
    toast.classList.add('show'); 
    setTimeout(() => toast.classList.remove('show'), 3000);
}

// --- FITUR 1: AI GENERATE JADWAL ---
function generateJadwalAI() {
    const aiContainer = document.querySelector('.ai-panel > div:nth-child(2)');
    if(!aiContainer) return;
    let tugasAktif = allTasks.filter(t => t.status === 'aktif');
    
    if (tugasAktif.length === 0) {
        showToast("Tidak ada tugas aktif untuk dijadwalkan!", "var(--warning-yellow)");
        return;
    }

    tugasAktif.sort((a, b) => {
        return new Date(`${a.deadline}T${a.jam}`) - new Date(`${b.deadline}T${b.jam}`);
    });

    let rundownHTML = `
        <div class="suggestion-box" style="border-left: 3px solid var(--edunotes-blue);">
            <h4 style="font-size:14px; margin-bottom:10px;">
                <i class="fa-solid fa-list-check" style="color:var(--edunotes-blue); margin-right:4px;"></i> Rundown Disarankan:
            </h4>
            <ul style="font-size:13px; color:var(--text-muted); line-height:1.6; padding-left:16px;">
    `;
            
    tugasAktif.slice(0, 3).forEach((t, index) => {
        rundownHTML += `
            <li style="margin-bottom:8px;">
                <strong style="color:#fff">${t.judul}</strong><br>
                Mata Kuliah: ${t.mapel}<br>
                Batas Waktu: ${t.deadline} pukul ${t.jam}
            </li>`;
    });

    rundownHTML += `</ul></div>`;
    
    const btnHtml = `
        <button onclick="generateJadwalAI()" style="width:100%; background:#2a2a2a; color:#fff; border:1px solid #444; padding:12px; border-radius:8px; cursor:pointer; font-weight:600;">
            <i class="fa-solid fa-rotate-right" style="color:#fff; margin-right:4px;"></i> Regenerate Jadwal
        </button>
    `;
    
    aiContainer.innerHTML = rundownHTML + btnHtml;
    showToast("Jadwal optimal berhasil dibuat!", "var(--normal-teal)");
}

// --- FITUR 2: FILTER RIWAYAT ---
let filterRiwayatAktif = 'semua';

function filterHistory(tipe) {
    filterRiwayatAktif = tipe;
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById('filter-' + tipe).classList.add('active');
    renderHistory();
}

function renderHistory() {
    const grid = document.getElementById('history-grid'); 
    if(!grid) return;
    grid.innerHTML = '';
    
    let riwayat = allTasks.filter(t => t.status !== 'aktif');
    if (filterRiwayatAktif !== 'semua') {
        riwayat = riwayat.filter(t => t.status === filterRiwayatAktif);
    }

    if (riwayat.length === 0) {
        grid.innerHTML = `<p style="color:var(--text-muted); font-size:14px; font-style:italic;">Tidak ada tugas pada kategori ini.</p>`;
        return;
    }

    riwayat.forEach(t => {
        let sIcon = t.status === 'selesai' ? '✅ Selesai' : t.status === 'terlewat' ? '❌ Terlewat' : '🗑️ Dihapus';
        let sColor = t.status === 'selesai' ? 'var(--normal-teal)' : t.status === 'terlewat' ? 'var(--warning-yellow)' : '#555';
        let tanggalAksi = t.actionDate ? t.actionDate : '-';

        grid.innerHTML += `
            <div class="task-card normal" style="opacity: ${t.status==='dihapus'?0.5 : 0.8}">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <h3 style="font-size:15px; color:#fff; text-decoration: ${t.status==='selesai'||t.status==='dihapus' ? 'line-through': 'none'};">${t.judul}</h3>
                        <p style="color:var(--text-muted); font-size:13px; margin-bottom:10px;">${t.mapel}</p>
                        <span class="badge" style="color:var(--text-muted)">Aksi: ${tanggalAksi}</span>
                    </div>
                    <span class="status-badge" style="color:${sColor}; background:rgba(255,255,255,0.05); padding: 4px 10px;">${sIcon}</span>
                </div>
            </div>`;
    });
}

// --- FITUR 3: UBAH PASSWORD ---
function toggleModalPassword() {
    const modal = document.getElementById('modalPassword');
    if(!modal) return;
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

    if (!pLama || !pBaru || !pKonfirm) {
        showToast("Semua kolom harus diisi!", "var(--warning-yellow)"); 
        return;
    }

    if (pBaru !== pKonfirm) {
        showToast("Konfirmasi password tidak cocok!", "var(--urgent-red)"); 
        return;
    }

    toggleModalPassword();
    showToast("Password Berhasil Diubah", "var(--normal-teal)");
}

// --- FITUR 4: KONFIRMASI DANGER ZONE ---
let aksiKonfirmasi = null;

function openConfirmModal(judul, pesan, callback) {
    document.getElementById('confirm-title').innerText = judul;
    document.getElementById('confirm-msg').innerText = pesan;
    aksiKonfirmasi = callback;
    document.getElementById('modalConfirm').classList.add('show');
}

function closeConfirmModal() {
    document.getElementById('modalConfirm').classList.remove('show');
    aksiKonfirmasi = null;
}

// Pasang event listener untuk tombol konfirmasi
document.addEventListener("DOMContentLoaded", () => {
    const btnConfirm = document.getElementById('btn-confirm-action');
    if(btnConfirm){
        btnConfirm.addEventListener('click', function() {
            if (aksiKonfirmasi) aksiKonfirmasi();
            closeConfirmModal();
        });
    }
});

function hapusSemuaTugas() {
    openConfirmModal(
        "Hapus Semua Tugas", 
        "Apakah Anda yakin ingin menghapus seluruh tugas? Tugas akan dipindahkan ke Riwayat dengan status 'Dihapus'.", 
        function() {
            const tanggalAksi = new Date(HARI_INI).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
            allTasks.forEach(t => {
                if (t.status !== 'dihapus') {
                    t.status = 'dihapus';
                    t.actionDate = tanggalAksi;
                }
            });
            renderDashboard(); 
            renderCalendar(); 
            renderHistory(); 
            showToast("Seluruh tugas dipindahkan ke Riwayat", "var(--urgent-red)");
        }
    );
}

function hapusAkun() {
    openConfirmModal(
        "Hapus Akun Permanen", 
        "Semua data profil, tugas, dan histori Anda akan hilang selamanya. Apakah Anda yakin ingin melanjutkan?", 
        function() {
            showToast("Memproses penghapusan akun...", "var(--urgent-red)");
            setTimeout(() => {
                document.body.innerHTML = `
                    <div style="height:100vh; display:flex; align-items:center; justify-content:center; flex-direction:column; background:var(--bg-dark);">
                        <i class="fa-solid fa-user-xmark" style="font-size:64px; color:var(--urgent-red); margin-bottom:24px;"></i>
                        <h1 style="color:#fff; font-family:Inter, sans-serif; margin-bottom:10px;">Akun Berhasil Dihapus</h1>
                        <p style="color:var(--text-muted); font-family:Inter, sans-serif;">Terima kasih telah menggunakan EduNOTES.</p>
                    </div>`;
            }, 1500);
        }
    );
}

// FUNGSI AKUN INTERAKTIF
function toggleEditProfil() {
    const inputs = [document.getElementById('prof-nama'), document.getElementById('prof-email'), document.getElementById('prof-jurusan')];
    const btn = document.getElementById('btn-edit-profil');
    const isRead = inputs[0].hasAttribute('readonly');
    if(isRead) {
        inputs.forEach(i => i.removeAttribute('readonly')); inputs[0].focus();
        btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Profil'; btn.style.background = 'var(--normal-teal)'; btn.style.color = '#000';
    } else {
        inputs.forEach(i => i.setAttribute('readonly', true));
        btn.innerHTML = '<i class="fa-solid fa-pen"></i> Edit Profil'; btn.style.background = 'var(--edunotes-blue)'; btn.style.color = '#fff';
        document.getElementById('disp-name').innerText = inputs[0].value;
        document.getElementById('disp-email').innerText = inputs[1].value;
        showToast('Profil diperbarui!', 'var(--normal-teal)');
    }
}

function toggleNotif(el) { el.classList.toggle('on'); showToast('Pengaturan disimpan', 'var(--normal-teal)'); }

periksaTugasTerlewat(); 
renderDashboard();


// =====================================================================
// PENTING UNTUK LARAVEL VITE: DAFTARKAN FUNGSI KE OBJECT WINDOW
// Agar tombol di HTML (contoh: onclick="simpanTugas()") tidak Error
// =====================================================================
window.showPage = showPage;
window.simpanTugas = simpanTugas;
window.toggleModal = toggleModal;
window.handleOverlayClick = handleOverlayClick;
window.toggleDeskripsi = toggleDeskripsi;
window.updateStatusTugas = updateStatusTugas;
window.gantibulan = gantibulan;
window.lihatAgendaTanggal = lihatAgendaTanggal;
window.toggleAIPanel = toggleAIPanel;
window.generateJadwalAI = generateJadwalAI;
window.filterHistory = filterHistory;
window.toggleModalPassword = toggleModalPassword;
window.prosesUbahPassword = prosesUbahPassword;
window.hapusSemuaTugas = hapusSemuaTugas;
window.hapusAkun = hapusAkun;
window.toggleEditProfil = toggleEditProfil;
window.toggleNotif = toggleNotif;