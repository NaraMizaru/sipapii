@extends('layouts.app')
@section('title', 'Data Siswa')

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
                        <h4 class="card-title">Daftar Siswa</h4>
                        <div class="float-right">
                            <a href="{{ route('admin.siswa.form') }}" class="btn btn-success"><i
                                    class="fa-regular fa-add"></i></a>
                            <button class="btn btn-warning"><i class="fa-regular fa-file-import text-white"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered nowrap w-100" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                                <th>Tahun Ajar</th>
                                <th class="text-center">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

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
                    url: "{{ route('admin.siswa.data') }}",
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
                        data: 'siswa.nis',
                        orderable: false,
                    },
                    {
                        data: 'nama_lengkap',
                        orderable: true,
                    },
                    {
                        data: 'siswa.jenis_kelamin',
                        orderable: true,
                    },
                    {
                        data: 'siswa.kelas.nama',
                        orderable: true,
                    },
                    {
                        data: 'siswa.tahun_ajar.tahun_ajar',
                        orderable: true,
                    },
                    {
                        data: 'is_active',
                        orderable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            const status = data == 1 ? 'Aktif' : 'Tidak Aktif';

                            return `<div class="badge ${data == 1 ? 'bg-success' : 'bg-danger'} d-block">${status}</div>`;
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            let editUrl = "{{ route('admin.siswa.form', ':id') }}";
                            editUrl = editUrl.replace(':id', data);

                            let editBtn =
                                `<a href="${editUrl}" class="btn btn-primary"><i class="fa-regular fa-edit"></i></a>`;
                            let deleteBtn =
                                `<button onclick="confirmDelete('${row.id}')" class="btn btn-danger"><i class="fa-regular fa-trash"></i></button>`;
                            return `<div class="d-flex flex-row gap-2">${editBtn}${deleteBtn}</div>`;
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
