<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaJurnalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurnal::orderBy('created_at', 'DESC')
            ->where('siswa_id', Auth::user()->siswa->id);

        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggalAwal = Carbon::parse($request->tanggal_awal)->format('Y-m-d');
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->format('Y-m-d');

            $query->whereBetween('tanggal', [
                $tanggalAwal,
                $tanggalAkhir,
            ]);
        }

        $data['jurnal'] = $query->paginate(10);

        $data['jurnal']->getCollection()->transform(function ($jurnal) {
            $jurnal->tanggal = Carbon::parse($jurnal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY');
            return $jurnal;
        });

        return view('siswa.jurnal', [], ['menu_type' => 'jurnal'])->with($data);
    }
}
