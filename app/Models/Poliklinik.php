<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    use HasFactory;

    protected $table = 'poliklinik';

    protected $fillable = [
        'kode_poli',
        'nama_poli',
        'dokter_id',
    ];

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
