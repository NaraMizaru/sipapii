@extends('layouts.app-2')

@php
    if (Request::query('type') == 'masuk') {
        $status = 'Masuk';
    } elseif (Request::query('type') == 'pulang') {
        $status = 'Pulang';
    } else {
        $status = '';
    }
@endphp

@section('title', 'Absen ' . $status)

@push('css')
    {{-- CSS Only For This Page --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
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

        .webcam,
        .webcam video {
            display: inline-block;
            width: 100% !important;
            height: auto !important;
            margin: auto;
            text-align: center;
            border-radius: 15px;
            overflow: hidden;
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
                <div class="divider-text">Lat-Long: <span id="latLong"></span></div>
            </div>

            <div class="row">
                @include('template.feedback')
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <form action="{{ route('siswa.absen.post', ['type' => strtolower($status)]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card border">
                            <div class="card-body text-center">
                                <!-- Kamera Desktop #m1 -->
                                <div class="d-inline-block text-center">
                                    <div id="camera" class="d-none mb-3"></div>
                                </div>
                                <!-- Dump Image #m1 -->
                                <img id="dumpImage" src="{{ asset('assets/static/images/camera.png') }}"
                                    class="img-fluid mb-3">
                                <!-- Preview Container #m1 -->
                                <div id="preview" class="d-none">
                                    <img id="capturedImage" class="img-fluid">
                                </div>
                                <!-- Hidden File Input #m1 -->
                                <input type="file" accept="image/*" capture="camera" name="camera_data" id="cameraInput"
                                    class="d-none">
                                <input type="hidden" name="lat" id="latitude" value="">
                                <input type="hidden" name="long" id="longitude" value="">
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-success d-block w-100" id="takePicture">
                                    <i class="fa-regular fa-camera me-2"></i>Ambil Gambar
                                </button>

                                <div class="row d-none" id="btnGroupAbsen">
                                    <div class="col-8 col-md-10">
                                        <button type="submit" class="btn btn-success w-100" id="takePicture">
                                            <i class="fa-regular fa-camera me-2"></i>Absen {{ $status }}
                                        </button>
                                    </div>
                                    <div class="col-4 col-md-2">
                                        <button type="button" class="btn btn-warning w-100" id="retakePicture">
                                            <i class="fa-regular fa-rotate"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div style="margin-bottom: 7rem;"></div>
@endsection

@push('js')
    {{-- JS Only For This Page --}}
    <script src="{{ asset('assets/extensions/webcamjs/webcamjs.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/static/js/helper/cam.js') }}"></script>
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const long = position.coords.longitude;

                    $('#latitude').val(lat);
                    $('#longitude').val(long);

                    $('#latLong').text(`${lat}, ${long}`);

                    Toastify({
                        text: "Lokasi anda telah terdektesi",
                        duration: 3000,
                        close: true,
                        backgroundColor: "#198754",
                    }).showToast()
                },
                function(error) {
                    Toastify({
                        text: "Gagal mendeteksi lokasi anda",
                        duration: 3000,
                        close: true,
                        backgroundColor: "#dc3545",
                    }).showToast()
                }
            );
        } else {
            Toastify({
                text: "Geolocation tidak didukung pada browser anda",
                duration: 3000,
                close: true,
                backgroundColor: "#ffc107",
            }).showToast()
        }
    </script>
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