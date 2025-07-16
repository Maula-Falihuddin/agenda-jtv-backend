<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Activity extends Model
{
    use HasFactory;

    // Nama tabel eksplisit
    protected $table = 'activity';

    // Kolom yang bisa diisi
    protected $fillable = [
        'user_id',     // ← Tambahkan ini agar bisa diisi saat create
        'day',
        'hour',
        'minute',
        'description',
        'is_checked',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
