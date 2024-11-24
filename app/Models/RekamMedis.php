<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'tanggal_waktu_pemeriksaan',
        'keluhan',
        'hasil_diagnosa',
        'tindakan_pengobatan',
        'resep_dokter',
        'dokter_id',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function pasienUser()
    {
        return $this->belongsTo(User::class, 'pasien_id', 'id');
    }
}
