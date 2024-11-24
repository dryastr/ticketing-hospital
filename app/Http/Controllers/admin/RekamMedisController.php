<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pasien_id)
    {

        $pasien = Pasien::findOrFail($pasien_id);
        $rekamMedis = RekamMedis::where('pasien_id', $pasien_id)->get();

        return view('admin.rekammedis.index', compact('pasien', 'rekamMedis'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_waktu_pemeriksaan' => 'required|date',
            'keluhan' => 'required|string',
            'hasil_diagnosa' => 'required|string',
            'tindakan_pengobatan' => 'required|string',
            'resep_dokter' => 'required|string',
            'dokter_id' => 'required|exists:users,id',
            'antrian_id' => 'required|exists:antrians,id',
        ]);


        RekamMedis::create([
            'pasien_id' => $request->pasien_id,
            'tanggal_waktu_pemeriksaan' => $request->tanggal_waktu_pemeriksaan,
            'keluhan' => $request->keluhan,
            'hasil_diagnosa' => $request->hasil_diagnosa,
            'tindakan_pengobatan' => $request->tindakan_pengobatan,
            'resep_dokter' => $request->resep_dokter,
            'dokter_id' => $request->dokter_id,
        ]);


        $antrian = Antrian::findOrFail($request->antrian_id);
        $antrian->status = 'done';
        $antrian->save();

        return redirect()->route('rekam_medis.show', ['pasienId' => $request->pasien_id, 'antrian' => $request->antrian_id])
            ->with('success', 'Rekam Medis berhasil ditambahkan dan status antrian diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show($pasienId, Request $request)
    {
        $antrianId = $request->query('antrian');

        $pasien = Pasien::findOrFail($pasienId);

        $rekamMedis = RekamMedis::where('pasien_id', $pasienId)->get();

        $antrian = Antrian::find($antrianId);

        if (!$antrian) {
            return abort(404, 'Antrian tidak ditemukan');
        }

        $nextAntrian = Antrian::where('status', 'waiting')->orderBy('nomor_antrian')->first();
        $lastAntrian = Antrian::where('status', 'waiting')->orderBy('nomor_antrian', 'desc')->first();

        $isLastAntrian = $lastAntrian && $antrianId == $lastAntrian->id;

        // dd($pasien);

        return view('admin.rekammedis.show', compact('pasien', 'rekamMedis', 'antrian', 'nextAntrian', 'isLastAntrian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
