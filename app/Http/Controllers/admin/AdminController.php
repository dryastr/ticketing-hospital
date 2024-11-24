<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahDokter = User::whereHas('role', function ($query) {
            $query->where('name', 'dokter');
        })->count();

        $jumlahPasien = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->count();

        $totalAntrian = Antrian::count();

        return view('admin.dashboard', compact('jumlahDokter', 'jumlahPasien', 'totalAntrian'));
    }
}
