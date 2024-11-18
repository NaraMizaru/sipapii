@extends('layouts.app')
@section('title', 'Data Guru Mapel PKL & Pembimbing')

@push('css')
    {{-- CSS Only For This Page --}}
    <link href="{{ asset('assets/extensions/datatables.net-responsive-bs5/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/extensions/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <section class="row">
        @include('template.feedback')

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Guru Mapel PKL & Pembimbing</h4>
                        <div class="float-right">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGuruModal"><i
                                    class="fa-regular fa-add"></i></button>
                            <button class="btn btn-warning"><i class="fa-regular fa-file-import text-white"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered nowrap w-100" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                {{-- <th>Foto Profile</th> --}}
                                <th>Nama</th>
                                <th>Nomor Whatsapp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addGuruModal" tabindex="-1" role="dialog" aria-labelledby="addGuruModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGuruModalTitle">Tambah Guru</h5>
                </div>
                <form action="{{ route('admin.guru.add') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Guru</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                placeholder="Masukan Nama Guru" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor-wa">Nomor Whatsapp</label>
                            <input type="text" class="form-control" id="nomor_wa" name="nomor_wa"
                                placeholder="Masukan Nomor Whatsapp" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn text-primary" data-bs-dismiss="modal">
                            <span>Batal</span>
                        </button>
                        <button type="submit" class="btn btn-success ms-1">
                            <span>Tambah</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    {{-- JS Only For This Page --}}
    <script src="{{ asset('assets/extensions/datatables.net-responsive-bs5/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-responsive-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-responsive-bs5/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('admin.guru.data') }}",
                    data: function(e) {
                        return e;
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: null,
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama_lengkap',
                        orderable: true,
                    },
                    {
                        data: 'guru.nomor_wa',
                        orderable: true,
                    },
                    {
                        data: 'id',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            let showBtn =
                                `<button class="btn btn-warning text-white"><i class="fa-regular fa-eye"></i></button>`;
                            let editBtn =
                                `<button class="btn btn-primary"><i class="fa-regular fa-edit"></i></button>`;
                            let deleteBtn =
                                `<button onclick="confirmDelete('${row.id}')" class="btn btn-danger"><i class="fa-regular fa-trash"></i></button>`;
                            return `<div class="d-flex flex-row gap-2">${showBtn}${editBtn}${deleteBtn}</div>`;
                        }
                    }
                ],
                dom: "<'row'<'col-12 col-sm-3'l><'col-12 col-sm-9 text-end text-sm-start'f>>" +
                    "<'row dt-row'<'col-12'tr>>" +
                    "<'row'<'col-12 col-sm-4 text-center text-sm-start'i><'col-12 col-sm-8 text-center text-sm-end'p>>",
                "language": {
                    "info": "Page _PAGE_ of _PAGES_",
                    "lengthMenu": "_MENU_ ",
                }
            });
        });
    </script>
    <script>
        const confirmDelete = (id) => {
            const deleteUrl = "{{ route('admin.siswa.delete', ':id') }}"

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan data yang sudah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl.replace(':id', id);
                    Swal.fire("Success, Kelas berhasil dihapus!", {
                        icon: "success",
                    });
                } else {
                    Swal.fire("Penghapusan kelas dibatalkan!");
                }
            });

        }
    </script>
@endpush
