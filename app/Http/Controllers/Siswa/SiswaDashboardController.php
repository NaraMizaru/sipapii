<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $data['siswa'] = Auth::user();

        return view('siswa.dashboard', [], ['menu_type' => 'dashboard'])->with($data);
    }
}
