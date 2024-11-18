<?php

namespace App\Http\Controllers\Admin\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminDataSiswaController extends Controller
{
    public function index()
    {
        return view('admin.siswa.data-siswa.index', [], ['menu_type' => 'siswa', 'submenu_type' => 'siswa-data']);
    }

    public function form($id = null)
    {
        $data['siswa'] = Siswa::where('user_id', $id)->first();
        $data['kelas'] = Kelas::orderBy('nama', 'ASC')->get();
        $data['tahunAjar'] = TahunAjar::orderBy('tahun_ajar', 'ASC')->get();

        return view('admin.siswa.data-siswa.form', [], ['menu_type' => 'siswa', 'submenu_type' => 'siswa-data'])->with($data);
    }

    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'nis' => 'required',
            'jenis_kelamin',
            'kelas_id' => 'required',
            'tahun_ajar_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $user = User::updateOrCreate(['id' => @$id], [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->nis,
            'password' => Str::random(8),
            'role' => 'siswa',
        ]);

        if ($user) {
            Siswa::updateOrCreate(['user_id' => $user->id], [
                'user_id' => $user->id,
                'nis' => $request->nis,
                'jenis_kelamin' => $request->jenis_kelamin,
                'kelas_id' => $request->kelas_id,
                'tahun_ajar_id' => $request->tahun_ajar_id,
            ]);
        }

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil disimpan');
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
                $data->orderBy($columns[$orderBy]['data'], $orderDir)->where('role', 'siswa')->with('siswa', 'siswa.kelas', 'siswa.tahunAjar');
            } else {
                $data->orderBy('nama_lengkap', 'asc')->where('role', 'siswa')->with('siswa', 'siswa.kelas', 'siswa.tahunAjar');
            }
        } else {
            $data->orderBy('nama_lengkap', 'asc')->where('role', 'siswa')->with('siswa', 'siswa.kelas', 'siswa.tahunAjar');
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

    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil dihapus');
    }
}
