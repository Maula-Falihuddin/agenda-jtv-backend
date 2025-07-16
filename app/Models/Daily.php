<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Daily extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'daily';

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',     // ← Relasi ke user
        'tanggal',
        'jam',
        'judul',
        'deskripsi',
        'prioritas',
        'is_checked',
    ];

    /**
     * Relasi: setiap daily milik satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
