<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'nomor_rekam_medis',
        'user_id',
        'alamat',
        'tempat_tanggal_lahir',
        'jenis_kelamin',
        'status_perkawinan',
        'kontak_keluarga_terdekat',
        'pekerjaan',
        'pendidikan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'pasien_id');
    }
}
