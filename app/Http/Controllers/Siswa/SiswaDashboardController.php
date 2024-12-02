<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $data['siswa'] = Auth::user();
        $data['absen'] = Absen::where('siswa_id', Auth::user()->siswa->id)->where('tanggal', Carbon::now()->format('d-m-Y'))->first();

        return view('siswa.dashboard', [], ['menu_type' => 'dashboard'])->with($data);
    }
}
