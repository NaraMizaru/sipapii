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
    @php
        if (Request::query('type') == 'masuk') {
            $status = 'Masuk';
        } elseif (Request::query('type') == 'pulang') {
            $status = 'Pulang';
        } else {
            $status = '';
        }
    @endphp

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
                <div class="divider-text">Latitude: <span>12312312</span> - Longitude: <span>52341234</span></div>
            </div>

            <div class="row">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="card border">
                        <div class="card-body">
                            <img src="{{ asset('assets/static/images/camera.png') }}" class="img-fluid">
                        </div>
                        <div class="card-footer">
                          <div class="btn btn-success d-block"><i class="fa-regular fa-camera me-2"></i>Absen {{ $status }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 5rem;"></div>
    </div>
@endsection

@push('js')
    {{-- JS Only For This Page --}}
    <script src="{{ asset('assets/extensions/webcamjs/webcamjs.min.js') }}"></script>
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
