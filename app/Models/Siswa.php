<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'nis',
        'jenis_kelamin',
        'kelas_id',
        'tahun_ajar_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id', 'id');
    }
}
