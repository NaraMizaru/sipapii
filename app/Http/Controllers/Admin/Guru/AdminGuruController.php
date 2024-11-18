<?php

namespace App\Http\Controllers\Admin\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminGuruController extends Controller
{
    public function index()
    {
        return view('admin.guru.index', [], ['menu_type' => 'guru-mapel-pembimbing']);
    }

    public function addGuru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'nomor_wa' => 'required|digits_between:10,15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $namaDepan = strtoupper(substr($request->nama_lengkap, 0, 3));
        $nomorWa = preg_replace('/\D/', '', $request->nomor_wa);
        $digitTerakhirWa = substr($nomorWa, -2);
        $username = $namaDepan . $digitTerakhirWa;

        $counter = 1;
        $originalUsername = $username;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        $user = new User();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $username;
        $user->password = Str::random(8);
        $user->role = 'guru';
        $user->save();

        if ($user) {
            $guru = new Guru();
            $guru->user_id = $user->id;
            $guru->nomor_wa = $request->nomor_wa;
            $guru->save();
        }

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil disimpan');
    }



    public function data(Request $request)
    {
        $length = intval($request->input('length', 15));
        $start = intval($request->input('start', 0));
        $search = $request->input('search');
        $columns = $request->input('columns');
        $order = $request->input('order');

        $data = User::query();

        if (!empty($order)) {
            $order = $order[0];
            $orderBy = $order['column'];
            $orderDir = $order['dir'];

            if (isset($columns[$orderBy]['data'])) {
                $data->orderBy($columns[$orderBy]['data'], $orderDir)->where('role', 'guru')->with('guru');
            } else {
                $data->orderBy('nama_lengkap', 'asc')->where('role', 'guru')->with('guru');
            }
        } else {
            $data->orderBy('nama_lengkap', 'asc')->where('role', 'guru')->with('guru');
        }

        $count = $data->count();
        $countFiltered = $count;

        if (!empty($search['value'])) {
            $data->where('nama_lengkap', 'LIKE', '%' . $search['value'] . '%');
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
