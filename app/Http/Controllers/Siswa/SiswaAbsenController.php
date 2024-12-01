<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Instansi;
use App\Models\Menempati;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiswaAbsenController extends Controller
{
  public function index(Request $request)
  {
    $data['siswa'] = Auth::user();

    if ($request->query('type') != 'masuk' && $request->query('type') != 'pulang') {
      return redirect()->route('siswa.dashboard')->with('error', 'Invalid type absen');
    }

    return view('siswa.absen')->with($data);
  }

  public function absen(Request $request, $id = null)
  {
    if ($request->query('type') != 'masuk' && $request->query('type') != 'pulang') {
      return redirect()->route('siswa.dashboard')->with('error', 'Invalid type absen');
    }

    $validator = Validator::make($request->all(), [
      'camera_data' => 'required|file',
      'lat' => 'required|numeric|between:-90,90',
      'long' => 'required|numeric|between:-180,180',
      'status' => 'nullable|in:Hadir,Sakit,Izin',
      'alasan' => 'required_if:status,Izin,Sakit',
    ]);

    if ($validator->fails()) {
      return redirect()->route('siswa.dashboard')->withErrors($validator->errors())->withInput($request->all());
    }

    $menempati = Menempati::where('siswa_id', Auth::user()->siswa->id)->with('instansi')->first();

    $jarak = $this->calculateDistance($request->lat, $request->long, $menempati->instansi->latitude, $menempati->instansi->longitude);

    $input = $request->all();
    $input['siswa_id'] = Auth::user()->siswa->id;
    $input['tanggal'] = Carbon::now()->format('d-m-Y');
    $input['latitude'] = $request->lat;
    $input['longitude'] = $request->long;
    $input['status'] = 'Hadir';
    $input['alasan'] = $request->alasan;
    $input['jarak'] = $jarak;

    if ($request->hasFile('camera_data')) {
      $file = $request->camera_data;

      $storePath = 'absen' . '/' . Auth::user()->siswa->id . '/' . Carbon::now()->format('d-m-Y');

      $storedFile = $file->storeAs($storePath, $file->hashName());
      $filePath = Storage::url($storedFile);

      $input['foto'] = $filePath;
    }

    if ($request->query('type') == 'masuk') {
      $input['jam_masuk'] = Carbon::now()->format('H:i');
    } else if ($request->query('type') == 'pulang') {
      $input['jam_pulang'] = Carbon::now()->format('H:i');
    } else {
      return redirect()->route('siswa.dashboard');
    }

    Absen::updateOrCreate(['id' => @$id], $input);
  }
}
