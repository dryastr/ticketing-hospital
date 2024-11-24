<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Poliklinik;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role->name !== 'dokter') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses.');
        }

        $poliklinik = Poliklinik::where('dokter_id', $user->id)->first();

        if (!$poliklinik) {
            return view('dokter.dashboard', [
                'nextAntrian' => null,
                'nextThreeAntrians' => collect(),
            ])->with('info', 'Tidak ada poliklinik terkait.');
        }

        $nextAntrian = Antrian::where('status', 'waiting')
            ->where('poliklinik_id', $poliklinik->id)
            ->orderBy('nomor_antrian')
            ->first();

        $nextThreeAntrians = $nextAntrian
            ? Antrian::where('status', 'waiting')
            ->where('poliklinik_id', $poliklinik->id)
            ->where('nomor_antrian', '>', $nextAntrian->nomor_antrian)
            ->orderBy('nomor_antrian')
            ->take(3)
            ->get()
            : collect();

        return view('dokter.dashboard', compact('nextAntrian', 'nextThreeAntrians'));
    }
}
