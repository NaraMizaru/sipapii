<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaRiwayatController extends Controller
{
    public function index()
    {
        return view('siswa.riwayat', [], ['menu_type' => 'riwayat']);
    }
}
