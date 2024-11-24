<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Pasien;
use App\Models\Poliklinik;
use App\Models\User;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $antrians = Antrian::where('status', 'waiting')->get();

        return view('user.home', compact('antrians'));
    }

    public function create(Request $request)
    {
        // Ambil user_id dari user yang sedang login
        $user_id = auth()->id();

        // Cek apakah user yang sedang login terdaftar sebagai pasien
        $pasien = Pasien::where('user_id', $user_id)->first();

        // Jika pasien tidak ditemukan, tampilkan pesan error
        if (!$pasien) {
            return redirect()->route('home')->with('error', 'Pasien tidak ditemukan. Pastikan Anda terdaftar sebagai pasien.');
        }

        // Ambil poliklinik_id dari input request
        $poliklinik_id = $request->input('poliklinik_id');
        $poliklinik = Poliklinik::find($poliklinik_id);

        // Cek apakah poliklinik ada
        if (!$poliklinik) {
            return redirect()->route('home')->with('error', 'Poliklinik tidak ditemukan.');
        }

        // Ambil dokter_id dari poliklinik
        $dokter_id = $poliklinik->dokter_id;

        // Cek apakah dokter tersedia untuk poliklinik ini
        if (!$dokter_id) {
            return redirect()->route('home')->with('error', 'Dokter untuk poliklinik ini tidak tersedia.');
        }

        // Generate nomor_antrian baru
        $nomor_antrian = Antrian::max('nomor_antrian') + 1;

        // Simpan data antrian baru
        Antrian::create([
            'nomor_antrian' => $nomor_antrian,
            'pasien_id' => $pasien->id, // Gunakan id pasien yang ditemukan di tabel pasien
            'poliklinik_id' => $poliklinik_id,
            'dokter_id' => $dokter_id,
            'status' => 'waiting',
        ]);

        dd($request->all());

        // Redirect kembali dengan pesan sukses
        return redirect()->route('home')->with('success', 'Antrian berhasil didaftarkan!');
    }
}
