<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Mengambil semua tugas milik user yang sedang login
    public function index()
    {
        // CARA PALING AMAN: Langsung cari berdasarkan ID User tanpa perlu relasi khusus
        $tasks = Task::where('user_id', Auth::id())->get();
        return response()->json($tasks);
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        $task = Task::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'mapel' => $request->mapel ?? 'Tanpa Kategori',
            'deadline' => $request->deadline,
            'jam' => $request->jam ?? '23:59:00',
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
        ]);

        return response()->json(['message' => 'Berhasil ditambahkan', 'task' => $task]);
    }

    // Mengubah status tugas (Selesai / Dihapus / Terlewat)
    public function updateStatus(Request $request, $id)
    {
        $task = Task::where('id', $id)->where('user_id', Auth::id())->first();
        if ($task) {
            $task->update([
                'status' => $request->status,
                'action_date' => date('d M Y')
            ]);
            return response()->json(['message' => 'Status diperbarui']);
        }
        return response()->json(['message' => 'Gagal menemukan tugas'], 400);
    }

    // Danger Zone: Hapus semua tugas (ubah status jadi dihapus)
    public function destroyAll()
    {
        Task::where('user_id', Auth::id())->update([
            'status' => 'dihapus',
            'action_date' => date('d M Y')
        ]);
        return response()->json(['message' => 'Semua tugas dipindah ke riwayat']);
    }
}