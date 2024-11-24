<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Pasien;
use App\Models\Poliklinik;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $antrians = Antrian::where('status', 'waiting')->get();

        return view('user.dashboard', compact('antrians'));
    }

    public function create(Request $request)
    {
        $user_id = auth()->id();
        $pasien = Pasien::where('user_id', $user_id)->first();
        if (!$pasien) {
            return redirect()->route('home')->with('error', 'Pasien tidak ditemukan. Pastikan Anda terdaftar sebagai pasien.');
        }

        $poliklinik_id = $request->input('poliklinik_id');
        $poliklinik = Poliklinik::find($poliklinik_id);

        if (!$poliklinik) {
            return redirect()->route('home')->with('error', 'Poliklinik tidak ditemukan.');
        }

        $dokter_id = $poliklinik->dokter_id;

        if (!$dokter_id) {
            return redirect()->route('home')->with('error', 'Dokter untuk poliklinik ini tidak tersedia.');
        }

        $nomor_antrian = Antrian::max('nomor_antrian') + 1;

        Antrian::create([
            'nomor_antrian' => $nomor_antrian,
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik_id,
            'dokter_id' => $dokter_id,
            'status' => 'waiting',
        ]);

        return redirect()->route('home')->with('success', 'Antrian berhasil didaftarkan!');
    }
}
