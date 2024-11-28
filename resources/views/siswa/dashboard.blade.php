@extends('layouts.app-2')
@section('title', 'Siswa Dashboard')

@push('css')
    {{-- CSS Only For This Page --}}
@endpush

@section('content')
    <div class="bg-primary position-relative" style="min-height: 15vh; padding: 0 1rem ;">
        <div class="position-absolute start-50 translate-middle-x w-100 card shadow-lg p-4 rounded-4"
            style="z-index: 1; max-width: calc(100% - 2rem); top: 10%;">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <p id="greetings">Selamat Siang</p>
                            <h2 id="namaLengkap">Muhammad Rifaa Siraajudin Sugandi</h2>
                        </div>
                        <div class="col-6 d-flex align-items-center justify-content-end">
                            <div class="text-end">
                                <p>Senin, 21 November 2024</p>
                                <h3>10:23:10</h3>
                            </div>
                        </div>
                    </div>

                    <div class="divider">
                        <div class="divider-text">Status Absensi</div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mt-2">
                            <a href="" class="btn btn-success d-block w-100 rounded-5">
                                <div class="d-block">
                                    <h5 class="p-0 m-0">Jam Masuk</h5>
                                    <p class="p-0 m-0">Belum Absen</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 mt-2">
                            <a href="" class="btn btn-danger d-block w-100 rounded-5">
                                <div class="d-block">
                                    <h5 class="p-0 m-0">Jam Masuk</h5>
                                    <p class="p-0 m-0">Belum Absen</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        test
    </div>
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
@endpush
