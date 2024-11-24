<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CronJobController extends Controller
{
    public function resetAntrian(Request $request)
    {
        DB::table('antrians')
            ->where('status', 'waiting')
            ->update(['nomor_antrian' => DB::raw('1')]);

        return response()->json(['message' => 'Antrian berhasil direset.']);
    }
}
