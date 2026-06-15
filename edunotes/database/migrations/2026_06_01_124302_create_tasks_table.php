<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // Menghubungkan tugas dengan pemilik akun (user)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            
            // Kolom data tugas sesuai struktur EduNOTES
            $table->string('judul');
            $table->string('mapel')->default('Tanpa Kategori');
            $table->date('deadline');
            $table->time('jam')->default('23:59:00');
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('aktif'); // Status: aktif, selesai, terlewat, dihapus
            $table->string('action_date')->nullable(); // Mencatat tanggal aksi (selesai/dihapus)
            
            $table->timestamps(); // Otomatis membuat created_at dan updated_at
        });
    }
};
