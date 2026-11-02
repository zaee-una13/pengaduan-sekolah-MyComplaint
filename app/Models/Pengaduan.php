<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    public const URGENSI = ['rendah', 'sedang', 'tinggi'];

    protected $fillable = [
        'user_id',
        'category_id',
        'judul',
        'isi_laporan',
        'tanggal_kejadian',
        'lokasi',
        'urgensi',
        'foto',
        'status',
        'catatan_penyerahan',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}