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

    if (!Menempati::where('siswa_id', Auth::user()->siswa->id)->first()) {
      return redirect()->route('siswa.dashboard')->with('error', 'Anda belum menempati instansi');
    }

    if ($request->query('type') != 'masuk' && $request->query('type') != 'pulang') {
      return redirect()->route('siswa.dashboard')->with('error', 'Invalid type absen');
    }

    $absen = Absen::where('id', $request->query('absen_id'))->first();
    if (!$absen) {
      return redirect()->route('siswa.dashboard')->with('error', 'Anda belum melakukan absen masuk.');
    }

    $absenHariIni = Absen::where('siswa_id', Auth::user()->siswa->id)
      ->where('tanggal', Carbon::now()->format('d-m-Y'))
      ->first();

    if ($request->query('type') == 'masuk' && $absenHariIni && $absenHariIni->jam_masuk) {
      return redirect()->route('siswa.dashboard')->with('error', 'Anda sudah melakukan absen masuk');
    }

    if ($request->query('type') == 'pulang') {
      if (!$absenHariIni || !$absenHariIni->jam_masuk) {
        return redirect()->route('siswa.dashboard')->with('error', 'Anda belum melakukan absen masuk');
      }

      if ($absenHariIni->jam_pulang) {
        return redirect()->route('siswa.dashboard')->with('error', 'Anda sudah melakukan absen pulang');
      }
    }

    return view('siswa.absen')->with($data);
  }

  public function absen(Request $request)
  {
    $id = $request->query('absen_id');

    if ($request->query('type') != 'masuk' && $request->query('type') != 'pulang') {
      return redirect()->route('siswa.dashboard')->with('error', 'Invalid type absen');
    }

    $validator = Validator::make($request->all(), [
      'camera_data' => 'required|file',
      'lat' => 'required_if:type,masuk|numeric|between:-90,90',
      'long' => 'required_if:type,masuk|numeric|between:-180,180',
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

    if ($request->hasFile('camera_data')) {
      $file = $request->camera_data;

      $storePath = 'absen' . '/' . Auth::user()->siswa->id . '/' . Carbon::now()->format('d-m-Y');

      $storedFile = $file->storeAs($storePath, $file->hashName());
      $filePath = Storage::url($storedFile);

      if ($request->query('type') == 'masuk') {
        $input['foto_masuk'] = $filePath;
      } else if ($request->query('type') == 'pulang') {
        $input['foto_pulang'] = $filePath;
      }
    }

    if ($request->query('type') == 'masuk') {
      $input['jam_masuk'] = Carbon::now()->format('H:i');
      $input['jarak'] = $jarak;
    } else if ($request->query('type') == 'pulang') {
      $input['jam_pulang'] = Carbon::now()->format('H:i');

      
    } else {
      return redirect()->route('siswa.dashboard');
    }

    Absen::updateOrCreate(['id' => @$id], $input);
  }
}
