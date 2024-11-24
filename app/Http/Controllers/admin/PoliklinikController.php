<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Poliklinik;
use Illuminate\Http\Request;

class PoliklinikController extends Controller
{
    public function index()
    {
        $polikliniks = Poliklinik::with('dokter')->get();

        $doctors = \App\Models\User::whereHas('role', function ($query) {
            $query->where('name', 'dokter');
        })->get();

        return view('admin.poliklinik.index', compact('polikliniks', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_poli' => 'required|unique:poliklinik,kode_poli|max:10',
            'nama_poli' => 'required|max:100',
        ]);

        Poliklinik::create($request->all());

        return redirect()->route('poliklinik.index')->with('success', 'Poliklinik created successfully.');
    }

    public function update(Request $request, Poliklinik $poliklinik)
    {
        $request->validate([
            'kode_poli' => 'required|max:10|unique:poliklinik,kode_poli,' . $poliklinik->id,
            'nama_poli' => 'required|max:100',
        ]);

        $poliklinik->update($request->all());

        return redirect()->route('poliklinik.index')->with('success', 'Poliklinik updated successfully.');
    }

    public function destroy(Poliklinik $poliklinik)
    {
        $poliklinik->delete();
        return redirect()->route('poliklinik.index')->with('success', 'Poliklinik deleted successfully.');
    }
}
