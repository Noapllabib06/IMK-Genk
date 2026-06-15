<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // INI WAJIB ADA AGAR LARAVEL MENGIZINKAN PENYIMPANAN
    protected $fillable = [
        'user_id', 'judul', 'mapel', 'deadline', 'jam', 'deskripsi', 'status', 'action_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}