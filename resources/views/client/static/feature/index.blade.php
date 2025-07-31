@extends('layouts.template-home')

@section('title', __('Fitur dan Dukungan'))

@section('styles')
    <style>
        .price {
            text-align: justify;
        }

        .card-feature {
            min-height: 120px !important;
            max-height: 120px !important;
            text-align: center;
        }

        .img-statistic {
            object-fit: contain !important;
        }

        .card-item {
            min-height: 150px;
            max-height: 150px;
        }
    </style>
@endsection

@section('content')
    <section class="container-fluid position-relative bg-heros p-0">
        <div class="position-absolute bottom-0 start-0 w-100">
            <div class="container px-lg-5 px-3">
                <h1 class="text-white fw-semibold" data-aos="zoom-in-right" data-aos-duration="1000">@lang('Fitur dan Dukungan') </h1>
            </div>
        </div>
    </section>

    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12 fs-6 px-lg-5 px-3">
                    <div class="row" data-aos="zoom-in-up" data-aos-duration="1000">
                        <div class="col-12 mb-4">
                            <h2 class="fw-bold text-center">Fitur</h2>
                            <p class="text-center">Berikut adalah layanan yang bisa kamu dapatkan di situs OMG.ID </p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <div class="card rounded-small shadow-sm mb-3 py-3 inner-card-dark">
                                <div class="row g-0 d-flex">
                                    <div class="col-12 p-3 icon card-feature ">
                                        <img src="{{ asset('template/images/fitur1.svg') }}" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-12 ">
                                        <div class="card-body card-item">
                                            <h5 class="fw-bold">Item </h5>
                                            <p class="card-text">Dapatkan dukungan dari pendukungmu</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <div class=" card rounded-small shadow-sm mb-3 py-3 inner-card-dark">
                                <div class="row g-0">
                                    <div class="col-12 p-3 icon card-feature">
                                        <img src="{{ asset('template/images/fitur2.svg') }}" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-12 ">
                                        <div class="card-body card-item">
                                            <h5 class="fw-bold">Halaman kreator</h5>
                                            <p class="card-text">Buat halaman kreator dan sesuaikan dengan dirimu.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <div class="card rounded-small shadow-sm mb-3 py-3 inner-card-dark">
                                <div class="row g-0">
                                    <div class="col-12 p-3 icon card-feature">
                                        <img src="{{ asset('template/images/fitur3.svg') }}" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-12 ">
                                        <div class="card-body card-item">
                                            <h5 class="fw-bold">Social link</h5>
                                            <p class="card-text">Tambahkan akun media sosialmu supaya pendukungmu tetap update!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <div class="card rounded-small shadow-sm mb-3 py-3 inner-card-dark">
                                <div class="row g-0">
                                    <div class="col-12 p-3 icon card-feature">
                                        <img src="{{ asset('template/images/fitur4.svg') }}" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-12 ">
                                        <div class="card-body card-item">
                                            <h5 class="fw-bold">Goal</h5>
                                            <p class="card-text">Buat target pencapaian untuk karyamu.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <div class="card rounded-small shadow-sm mb-3 py-3 inner-card-dark">
                                <div class="row g-0">
                                    <div class="col-12 p-3 icon card-feature">
                                        <img src="{{ asset('template/images/fitur5.svg') }}" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-12 ">
                                        <div class="card-body card-item">
                                            <h5 class="fw-bold">Streaming overlay</h5>
                                            <p class="card-text">Berikan interaksi menarik di aktivitas live streaming mu.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <div class="card rounded-small shadow-sm mb-3 py-3 inner-card-dark">
                                <div class="row g-0">
                                    <div class="col-12 p-3 icon card-feature">
                                        <img src="{{ asset('template/images/fitur6.svg') }}" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-12 ">
                                        <div class="card-body card-item">
                                            <h5 class="fw-bold">Analytics</h5>
                                            <p class="card-text">Lihat insight yang kamu dapatkan sebagai kreator.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4 px-lg-5 px-md-4 px-0" data-aos="zoom-in-up" data-aos-duration="1000">
                        <div class="col-12">
                            <h2 class="fw-bold text-center mb-4">Harga</h2>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center mb-md-0 mb-3">
                            <img src="{{ asset('template/images/graphic2.png') }}" class="img-fluid img-statistic" alt="...">
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12 d-flex align-content-center flex-wrap">
                            <p class="ps-md-2 price">Untuk layanan dan fasilitas teknologi yang kami berikan pada platform OMG.ID, OMG.ID mengenakan biaya senilai XX% dari total donasi yang dihasilkan. Biaya ini kami gunakan untuk biaya operasional, pengembangan aplikasi, dan layanan lainnya untuk meningkatkan kemudahan user dalam melakukan transaksi. </p>
                            <p class="ps-md-2 price">OMG.ID menggunakan layanan payment gateway Midtrans selaku partner pembayaran GOPAY resmi, dan Xendit selaku partner pembayaran OVO, DANA, dan LINKAJA secara resmi. Oleh karena ini, dikenakan biaya dalam penggunaan payment gateway pada setiap proses donasi yang berhasil dilakukan. Untuk informasi lebih lanjut dapat dilihat pada Midtrans Pricing dan Xendit Payments. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection
