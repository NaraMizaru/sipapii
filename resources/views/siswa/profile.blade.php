@extends('layouts.app-2')
@section('title', 'Jurnal Siswa')

@push('css')
    {{-- CSS Only For This Page --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush

@section('content')
    <div class="px-4 py-4">
        <div class="row">
            <div class="col-12 col-md-8 order-2 order-md-1 mt-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title">Akun Saya</h3>
                    </div>
                    <form action="">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" name="nis" id="nis" class="form-control"
                                    value="{{ $siswa->nis }}">
                            </div>
                            <div class="form-group">
                                <label for="namaLengkap">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="namaLengkap" class="form-control"
                                    value="{{ $siswa->user->nama_lengkap }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="nama_lengkap" id="email" class="form-control"
                                    value="{{ $siswa->user->email }}" placeholder="Masukan email anda">
                            </div>
                            <div class="form-group">
                                <label for="jenisKelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenisKelaminId" class="form-control choices">
                                    <option value="Laki-laki" @selected($siswa->jenis_kelamin == 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected($siswa->jenis_kelamin == 'Perempuan')>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select name="kelas_id" id="kelasId" class="form-control choices">
                                    <option value="{{ $siswa->kelas_id }}" @selected($siswa->kelas_id == $siswa->kelas_id)>
                                        {{ $siswa->kelas->nama }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun Ajar</label>
                                <select name="tahun_ajar_id" id="tahunAjarId" class="form-control choices">
                                    <option value="{{ $siswa->tahun_ajar_id }}" @selected($siswa->tahun_ajar_id == $siswa->tahun_ajar_id)>
                                        {{ $siswa->tahunAjar->tahun_ajar }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-end">
                                <button class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-4 order-1 order-md-2 mt-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title text-center">Foto Profile</h3>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/static/images/faces/1.jpg') }}" alt=""
                                    class="img-fluid w-50 rounded-circle font-weight-bold">
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <button class="btn btn-primary btn-sm text-center mt-4">Ubah Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-4">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 7rem;"></div>
@endsection

@push('js')
    {{-- JS Only For This Page --}}
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script>
        let choices = document.querySelectorAll(".choices")
        let initChoice
        for (let i = 0; i < choices.length; i++) {
            if (choices[i].classList.contains("multiple-remove")) {
                initChoice = new Choices(choices[i], {
                    delimiter: ",",
                    editItems: true,
                    maxItemCount: -1,
                    removeItemButton: true,
                })
            } else {
                initChoice = new Choices(choices[i])
            }
        }
    </script>
@endpush
