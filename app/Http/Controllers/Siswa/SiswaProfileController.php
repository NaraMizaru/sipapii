<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaProfileController extends Controller
{
    public function index()
    {
        $data['siswa'] = Auth::user()->siswa;
        $data['kelas'] = Kelas::orderBy('nama', 'ASC')->get();
        $data['tahunAjar'] = TahunAjar::orderBy('tahun_ajar', 'ASC')->get();

        return view('siswa.profile', [], ['menu_type' => 'profile'])->with($data);
    }
}
