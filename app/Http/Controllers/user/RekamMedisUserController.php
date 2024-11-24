<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class RekamMedisUserController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $rekamMedis = RekamMedis::whereHas('pasien.user', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->get();

        return view('user.rekam_medis.index', compact('rekamMedis'));
    }
}
