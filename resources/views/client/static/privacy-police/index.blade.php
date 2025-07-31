@extends('layouts.template-home')

@section('title', __('page.privacy_police'))

@section('styles')
    <style>
        p {
            text-align: justify;
        }
    </style>
@endsection

@section('content')
    <section class="container-fluid position-relative bg-heros p-0">
        <div class="position-absolute bottom-0 start-0 w-100">
            <div class="container px-lg-5 px-3">
                <h1 class="text-white fw-semibold" data-aos="zoom-in-right" data-aos-duration="1000">@lang('page.privacy_police')</h1>
            </div>
        </div>
    </section>

    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12 fs-5 px-lg-5 px-3" data-aos="zoom-in-up" data-aos-duration="1000">
                    <p>Kebijakan-kebijakan yang ada pada halaman ini mengatur hal-hal yang bersangkutan dengan data yang diberikan oleh pengguna kepada pengelola situs untuk pemanfaatan fasilitas, fitur, jasa, dan/atau layanan yang ditawarkan oleh pengelola melalui platform OMG.ID.</p>
                    <p>Ketentuan-ketentuan yang bersangkutan dengan data bersifat mengikat seluruh pengguna situs tanpa terkecuali untuk mengikuti semua ketentuan yang telah ditetapkan oleh pengelola situs OMG.ID.</p>
                    <p>Ketentuan-ketentuan tersebut dituliskan sebagai berikut:</p>
                    <ol>
                        <li>OMG.ID berkewajiban untuk menjaga kerahasiaan data (yang diberikan pengguna kepada OMG.ID sebagai pemenuhan syarat atas pemanfaatan fasilitas, fitur, jasa, dan/atau layanan yang ditawarkan) yang tidak dapat ditampilkan dalam situs selama tidak ada perjanjian tertulis terlebih dahulu kepada pengguna. Kewajiban OMG.ID menjaga kerahasiaan data pengguna menjadi tidak berlaku apabila pengelola situs dipaksa oleh ketentuan hukum yang berlaku, perintah pengadilan, dan/atau perintah dari pihak yang berwenang untuk membuka data milik pengguna.</li>
                        <li>OMG.ID hanya bertanggung jawab atas data yang diberikan pengguna OMG.ID kepada pengelola situs sebagaimana yang telah ditentukan pada ketentuan sebelumnya.</li>
                        <li>Pengelola situs tidak bertanggung jawab atas pemberian atau pertukaran data yang dilakukan oleh pengguna di luar situs OMG.ID.</li>
                        <li>Pengelola situs OMG.ID berhak untuk mengubah ketentuan menyangkut data-data pengguna situs tanpa pemberitahuan terlebih dahulu dengan tanpa mengabaikan hak pengguna situs untuk dijaga kerahasiaan data sebagaimana yang telah ditentukan dalam butir (1)</li>
                        <li>Penghapusan atau penutupan akun pengguna situs OMG.ID dapat dilakukan dengan mengirimkan permintaan penghapusan akun ke alamat email xxx@omg.id. Pengguna situs OMG.ID memberikan informasi ke pihak pengelola situs bahwa pengguna merupakan pemilik akun tersebut. Akun pengguna situs OMG.ID akan dinonaktifkan setelah ada konfirmasi keabsahan identitas pengguna antara kedua belah pihak.</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection
