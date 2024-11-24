<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Pasien::with('rekamMedis')->get();

        // dd($patients);

        return view('admin.patient.index', compact('patients'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $patient = Pasien::with(['rekamMedis', 'user'])->findOrFail($id);

        return view('admin.patient.show', compact('patient'));
    }

    public function showByUser(User $user)
    {
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $rekamMedis = RekamMedis::where('pasien_id', $pasien->id)->get();

        if ($rekamMedis->isEmpty()) {
            return redirect()->back()->with('error', 'Rekam medis tidak ditemukan.');
        }

        return view('admin.patient.show', compact('user', 'pasien', 'rekamMedis'));
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
        $request->validate([
            'nomor_rekam_medis' => 'required|string',
            'alamat' => 'required|string',
            'tempat_tanggal_lahir' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'status_perkawinan' => 'required|string',
            'kontak_keluarga_terdekat' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'pendidikan' => 'nullable|string',
        ]);

        $patient = Pasien::findOrFail($id);
        $patient->update([
            'nomor_rekam_medis' => $request->nomor_rekam_medis,
            'alamat' => $request->alamat,
            'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_perkawinan' => $request->status_perkawinan,
            'kontak_keluarga_terdekat' => $request->kontak_keluarga_terdekat,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function printRekamMedis($id)
    {
        $patient = Pasien::with(['rekamMedis', 'user'])
            ->findOrFail($id);

        $pdf = PDF::loadView('admin.patient.rekam_medis_single_pdf', compact('patient'));
        return $pdf->download("rekam_medis_{$patient->user->name}.pdf");
    }
}
