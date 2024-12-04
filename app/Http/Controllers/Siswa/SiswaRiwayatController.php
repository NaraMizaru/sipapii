<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Menempati;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaRiwayatController extends Controller
{
    public function index()
    {
        $data['menempati'] = Menempati::where('siswa_id', Auth::user()->siswa->id)->first();

        return view('siswa.riwayat', [], ['menu_type' => 'riwayat'])->with($data);
    }

    public function data(Request $request)
    {
        $length = intval($request->input('length', 15));
        $start = intval($request->input('start', 0));
        $search = $request->input('search');
        $columns = $request->input('columns');
        $order = $request->input('order');

        $siswaId = $request->query('siswa_id');

        $data = Absensi::query()->where('siswa_id', $siswaId)->with(['siswa']);

        if (!empty($order)) {
            $order = $order[0];
            $orderBy = $order['column'];
            $orderDir = $order['dir'];

            if (isset($columns[$orderBy]['data'])) {
                $data->orderBy($columns[$orderBy]['data'], $orderDir);
            } else {
                $data->orderBy('tanggal', 'asc');
            }
        } else {
            $data->orderBy('tanggal', 'asc');
        }

        $count = $data->count();
        $countFiltered = $count;

        if (!empty($search['value'])) {
            $data->where('tanggal', 'LIKE', '%' . $search['value'] . '%');
                // ->orWhere('status', 'LIKE', '%' . $search['value'] . '%');
            $countFiltered = $data->count();
        }

        $data = $data->skip($start)->take($length)->get();

        $response = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $count,
            "recordsFiltered" => $countFiltered,
            "limit" => $length,
            "data" => $data
        ];

        return response()->json($response);
    }
}
