@extends('layouts.app-2')
@section('title', 'Siswa Dashboard')

@push('css')
    {{-- CSS Only For This Page --}}
    <style>
        .capsule {
            position: relative;
        }

        .capsule::before {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            content: "";
            display: block;
            height: 140px;
            background: #435ebe;
        }
    </style>
@endpush

@section('content')
    <div class="capsule pt-1 px-3">
        <div class="card p-4 shadow-lg">
            <div class="row">
                <div class="col-6">
                    <p id="greetings">Selamat Siang</p>
                    <h2 id="namaLengkap">{{ $siswa->nama_lengkap }}</h2>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <div class="text-end">
                        <p id="currentDate">Senin, 21 November 2024</p>
                        <h3 id="currentTime">10:23:10</h3>
                    </div>
                </div>
            </div>

            <div class="divider">
                <div class="divider-text">Status Absensi</div>
            </div>

            <div class="row">
                @include('template.feedback')

                <div class="col-12 col-md-6 mt-2">
                    <a href="{{ route('siswa.absen', ['type' => 'masuk']) }}"
                        class="btn btn-success d-block w-100 rounded-5 {{ @$absen->jam_masuk ? 'disabled' : '' }}">
                        <div class="d-block">
                            <h5 class="p-0 m-0 text-white">Absen Masuk</h5>
                            <p class="p-0 m-0">{{ @$absen->jam_masuk ?: 'Belum Absen' }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <a href="{{ route('siswa.absen', ['type' => 'pulang', 'absen_id' => @$absen->id]) }}"
                        class="btn btn-danger d-block w-100 rounded-5 {{ @$absen->jam_pulang ? 'disabled' : '' }}">
                        <div class="d-block">
                            <h5 class="p-0 m-0 text-white">Absen Pulang</h5>
                            <p class="p-0 m-0">{{ @$absen->jam_pulang ?: 'Belum Absen' }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4">
        <div class="mt-3">
            <h5>Rekap Absensi</h5>
        </div>
        <div class="row">
            <div class="col-6 col-md-3">
                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-start">
                                <i class="fa-regular fa-right-to-bracket fs-3 text-success"></i>
                                <div class="">
                                    <strong class="ms-3">Hadir</strong>
                                    <p class="ms-3 mb-0">0 Hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-start">
                                <i class="fa-regular fa-flag-swallowtail fs-3 text-primary"></i>
                                <div class="">
                                    <strong class="ms-3">Izin</strong>
                                    <p class="ms-3 mb-0">0 Hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-start">
                                <i class="fa-regular fa-face-thermometer fs-3 text-warning"></i>
                                <div class="">
                                    <strong class="ms-3">Sakit</strong>
                                    <p class="ms-3 mb-0">0 Hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-start">
                                <i class="fa-regular fa-alarm-exclamation fs-3 text-danger"></i>
                                <div class="">
                                    <strong class="ms-3">Terlambat</strong>
                                    <p class="ms-3 mb-0">0 Hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="px-4">
        <div class="mt-3">
            <h5>Data Jurnal</h5>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Senin, 18 Oktober 2024</h4>
                    </div>
                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt provident ad voluptates
                            veritatis ipsa earum
                            expedita doloribus, fugit assumenda qui dolor impedit consequatur, libero non perspiciatis?
                            Provident vitae sunt
                            fuga commodi, officiis doloribus laudantium dolores aperiam sint eligendi autem fugiat quas, sit
                            voluptatem
                            omnis? Minima dicta in soluta voluptatibus placeat corrupti laudantium tempore? Ipsa eligendi
                            quod unde hic
                            dolore debitis nihil aperiam culpa odio possimus, ducimus natus excepturi eveniet dolorem quo
                            ullam eum iure
                            assumenda nisi repellat earum at quam vitae doloremque! At voluptate vero quis sapiente! Odit
                            quae distinctio
                            quidem sed maxime fuga consequatur, quis perferendis! Ipsa, aliquid provident.
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="card-text">Status: <span class="text-danger">Belum Disetujui</span></p>
                            <div class="float-right">
                                <a href="" class="btn btn-primary">Ubah Jurnal</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div style="margin-bottom: 5rem;"></div>

@endsection

@push('js')
    {{-- JS Only For This Page --}}
    <script>
        $(document).ready(function() {
            const namaLengkap = $('#namaLengkap');
            const maxLength = 15;

            if (namaLengkap.length) {
                const fullName = namaLengkap.text().trim();

                if (fullName.length > maxLength) {
                    const shortenedName = fullName.slice(0, maxLength) + '...';
                    namaLengkap.text(shortenedName);
                }
            }

            const jam = new Date().getHours();
            let ucapan = "Selamat Siang";
            if (jam >= 5 && jam < 11) {
                ucapan = "Selamat Pagi";
            } else if (jam >= 11 && jam < 15) {
                ucapan = "Selamat Siang";
            } else if (jam >= 15 && jam < 18) {
                ucapan = "Selamat Sore";
            } else {
                ucapan = "Selamat Malam";
            }

            $("#greetings").text(ucapan);
        });
    </script>
    <script>
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        function updateClock() {
            const now = new Date();

            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();

            const hours = String(now.getHours()).padStart(2, "0");
            const minutes = String(now.getMinutes()).padStart(2, "0");
            const seconds = String(now.getSeconds()).padStart(2, "0");

            $("#currentDate").text(`${dayName}, ${date} ${monthName} ${year}`);
            $("#currentTime").text(`${hours}:${minutes}:${seconds}`);
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endpush
