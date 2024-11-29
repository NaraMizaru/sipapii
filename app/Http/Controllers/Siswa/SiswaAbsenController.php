<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaAbsenController extends Controller
{
  public function index(Request $request)
  {
    $data['siswa'] = Auth::user();

    return view('siswa.absen')->with($data);
  }

  public function absen(Request $request, $id)
  {
    $siswaId = $request->query('siswaId');

    if ($siswaId != $id) {
      return redirect()->route('siswa.dashboard');
    }

    $query = $request->query('type');
    $absen = Absen::where('siswa_id', $siswaId)->first();

    $input = $request->all();
    $input['siswa_id'] = $siswaId;
    $input['tanggal'] = Carbon::now()->format('d-m-Y');
    $input['latitude'] = $request->latitude;
    $input['longitude'] = $request->longitude;
    $input['status'] = $request->status;
    $alasan['alasan'] = $request->alasan;

    if ($query == 'masuk') {
    } else if ($query == 'pulang') {
    } else {
      return redirect()->route('siswa.dashboard');
    }
  }
}
