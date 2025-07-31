@extends('layouts.template-home')

@section('title', __('OMG.ID | Tempatnya content creator cari dukungan!'))

@section('styles')

@endsection

@section('content')
    <section class="banner">
        <div class="container-fluid px-3 pt-4 curved-bottom bg-primary" style="/*background-image: url({{ asset('template/images/background.png') }}); object-fit:cover;*/">
            <div class="container px-3 pt-4 pb-3">
                <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                    <div class="col-lg-6 text-white" data-aos="fade-up" data-aos-duration="1000">
                        <h2 class="display-5 fw-bold lh-1 mb-3 text-lg-start text-center">
                            <span class="typing-text" style="--n:53">Cara Fun Cari Dukungan!</span>
                        </h2>
                        <div class="d-none d-lg-block">
                            <p class="lead">Tempatnya para kreator bisa #DAPATTIP dari para penggemarnya sebagai apresiasi karya melalui live streaming.</p>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                <a href="{{ route('register') }}" type="button" class="btn btn-outline-secondary btn-getting-started rounded-pill btn-lg px-4">Mulai Berkarya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-sm-8 col-lg-6 mx-auto my-lg-5 my-sm-0 my-xs-0">
                        <img src="{{ asset('template/images/col-hero1.png') }}" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy" data-aos="fade-up" data-aos-duration="1000">
                    </div>
                    <div class="col-10 col-sm-8 col-lg-6 mx-auto w-100 m-0">
                        <div class="d-block d-lg-none text-white text-lg-start text-center" data-aos="fade-up" data-aos-duration="1000">
                            <p class="lead">Tempatnya para kreator bisa #DAPATTIP dari para penggemarnya sebagai apresiasi karya melalui live streaming.</p>
                            <div class="d-grid gap-2 d-flex justify-content-center">
                                <a href="{{ route('register') }}" type="button" class="btn btn-outline-secondary btn-getting-started rounded-pill btn-lg px-4">Mulai Berkarya</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-lg-end justify-content-md-end justify-content-center">
                    <img src="{{ asset('template/images/capsules.png') }}" class="position-absolute img-fluid img-capsule" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="section section-even card-deep-dark">
        <div class="container position-relative">
            <div class="row d-flex align-items-center">
                <div class="col-12 d-none d-lg-block d-md-block">
                    <img src="{{ asset('template/images/outline-purple.svg') }}" class="position-absolute" width="300" height="100" alt="" style="position: absolute; left: 0; top: -70px;">
                </div>
                <div class="col-12 d-flex justify-content-center ">
                    <div class="mt-2" data-aos="zoom-in-down" data-aos-duration="800">
                        <div class="d-block">
                            <h3 class="text-left mb-2 text-primary fw-bold"> Apa itu OMG.ID ?</h3>
                            <img src="{{ asset('template/images/arrows-green.svg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div data-aos="zoom-in-right" data-aos-duration="800">
                        <p class="pt-2 fs-5">OMG.ID merupakan platform dimana para kreator konten, live streamer, virtual youtuber, gamer, storyteller, musician, dsb mendapatkan dukungan finansial dari penggemarnya dengan cara asik dan simple! Selain bisa berinteraksi dengan penggemar, para kreator juga akan mendapatkan reward & apresiasi berupa donasi uang.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 px-3 py-4">
                    <!-- <img src="{{ asset('template/images/bg-detail.png') }}" class="img-fluid" alt=""> -->
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="position: relative;" data-aos="fade-up" data-aos-duration="800">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active btn btn primary" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class=" btn btn primary" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class=" btn btn primary" aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" class=" btn btn primary" aria-label="Slide 4"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('template/images/writer.png') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('template/images/gamers.png') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('template/images/dancer.png') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('template/images/bg4.png') }}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <img src="{{ asset('template/images/icon-slider.svg') }}" class="" alt="..." style="width:40%; position: absolute; bottom: -80px; right: 0; z-index: -1; ">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us -->
    <section class="section section-odd card-deep-dark">
        <div class="container position-relative">
            <div class="row">
                <div class="d-flex justify-content-center " style="margin-bottom: 27px;">
                    <div class="position-relative">
                        <h3 class="text-center mb-5 text-primary fw-bold" data-aos="zoom-in-down" data-aos-duration="800">
                            Kenapa Harus di OMG.ID?
                            <div class="col">
                                <img src="{{ asset('template/images/scribble-green.svg') }}" class="img-fluid position-absolute" alt="" style="z-index: -1; top: -30px; right: 0;">
                            </div>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 px-4 py-2 position-relative  mb-2" data-aos="flip-left">
                    <div class="col d-none d-lg-block">
                        <img src="{{ asset('template/images/shapemobile1.svg') }}" class=" position-absolute " width="180" alt="" style="left: -60px; top: -150px; z-index: -1;">
                    </div>
                    <div class="col d-lg-none">
                        <img src="{{ asset('template/images/shapemobile1.svg') }}" class=" position-absolute " width="80" alt="" style="left: 0; top: -60px; z-index: -1;">
                    </div>
                    <div class="card-body card-why bg-white shadow row card-dark">
                        <div class="col-3 pt-2">
                            <img src="{{ asset('template/images/streaming.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h5 class="fs-6 fw-bold">Mendukung semua platform streaming</h5>
                            <p class="">Bebas streaming dari platform manapun seperti Youtube, Facebook, Instagram, Tiktok, Twitch, dsb.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 px-4 py-2 mb-2" data-aos="flip-right">
                    <div class="card-body card-why bg-white shadow row card-dark">
                        <div class="col-3">
                            <img src="{{ asset('template/images/pencairan-dana.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h5 class="fs-6 fw-bold"> Pencairan dana minimum</h5>
                            <p class="">Kreator dapat mencairkan dana tip dari penggemar minimal Rp 50.000 ke e-wallet yang dimiliki. Setiap pencairan dana ke rekening e-wallet akan dikenakan potongan sebesar Rp 5.000;- + PPN.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 px-4 py-2 mb-2" data-aos="flip-left">
                    <div class="card-body card-why bg-white shadow row card-dark">
                        <div class="col-3">
                            <img src="{{ asset('template/images/fee-ringan.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">

                            <h5 class="fs-6 fw-bold">
                                Fee ringan
                            </h5>
                            <p class="">Biaya penanganan atau handling fee yang ringan hanya 2% dari tip kamu.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 px-4 py-2 mb-2 " data-aos="flip-left">
                    <div class="card-body card-why bg-white shadow row card-dark">
                        <div class="col-3">
                            <img src="{{ asset('template/images/payment.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9 ">
                            <h5 class="fs-6 fw-bold">
                                Banyak pilihan Metode bayar
                            </h5>
                            <p class="">OMG.ID mendukung banyak metode bayar yang bisa dipilih penggemar untuk memberi kamu tip.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 col-sm-12 px-4 py-2 mb-2 " data-aos="flip-right">
                    <div class="card-body card-why bg-white shadow row card-dark">
                        <div class="col-3 pt-2">
                            <img src="{{ asset('template/images/target.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h5 class="fs-6 fw-bold">
                                Tentukan target
                            </h5>
                            <p class="">Kamu bisa menentukan berapa target tip yang ingin dicapai..</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 px-4 col-sm-12 py-2 mb-2 position-relative" data-aos="flip-left">
                    <div class="card-body d-flex aligin-items-center card-why bg-white shadow row card-dark">
                        <div class="col-3">
                            <img src="{{ asset('template/images/social-media.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h5 class="fs-6 fw-bold">
                                Ruang Bicara
                            </h5>
                            <p class="">Sapa penggemar dan mengobrol jadi lebih seru melalui halaman interaktif.</p>
                        </div>
                    </div>
                    <!-- <img src="{{ asset('template/images/purple-primary.svg') }}" class=" position-absolute " width="200px" alt="" style="right: -70px; bottom: -100px; z-index: -1;"> -->
                </div>
            </div>
        </div>
    </section>

    <!-- How To -->
    <section class="section section-even card-deep-dark">
        <div class="container">
            <div class="col-lg-5 col-md-6 mx-auto px-0 d-none d-md-block d-lg-block " style="margin-bottom: 40px; position: relative !important;">
                <h3 class="text-center text-judul  text-primary fw-bold mt-3  px-0 ">
                    <div data-aos="zoom-in-down" data-aos-duration="800">Cara Dapat Tip di OMG.ID</div>
                    <div class="position-absolute" style="right: 90px; top: 30px; ">
                        <img src="{{ asset('template/images/crinkle-green.svg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="position-absolute" style="left: 30px; top: -20px;  z-index: -1;">
                        <img src="{{ asset('template/images/elipss-green.svg') }}" class="img-fluid" alt="" width="80">
                    </div>
                </h3>
            </div>
            <div class="col-lg-4 col-md-6 mx-auto px-0 d-md-none d-lg-none " style="margin-bottom: 40px; position: relative !important;">
                <h3 class="text-center text-judul  text-primary fw-bold mt-3  px-0 ">
                    Cara Dapat Tip di OMG.ID
                    <div class="position-absolute" style="right: 90px; top: 30px; ">
                        <img src="{{ asset('template/images/crinkle-green.svg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="position-absolute" style="left: 30px; top: -20px;  z-index: -1;">
                        <img src="{{ asset('template/images/elipss-green.svg') }}" class="img-fluid" alt="" width="80">
                    </div>
                </h3>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">
                    <div class="card card-omg-how my-3 shadow border-0 card-dark">
                        <div class="row g-0">
                            <div class="col-3">
                                <img src="{{ asset('template/images/1.png') }}" class="step-number position-absolute" alt="">
                            </div>
                            <div class="col-9">
                                <div class="pt-4 px-2">
                                    <img src="{{ asset('template/images/ic_acc.png') }}" alt="">
                                    <h6 class="fs-6 fw-bold pt-3">Daftar & Verifikasi Akun</h6>
                                    <p class="">Daftar & isi data diri di OMG.ID lalu verifikasi akun. Pilih username unik & menarik yang akan muncul di link yang bisa kamu share.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4 position-relative" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
                    <div class="card card-omg-how my-3 shadow border-0 card-dark">
                        <div class="row g-0">
                            <div class="col-3">
                                <img src="{{ asset('template/images/2.png') }}" class="step-number step-2 position-absolute" alt="">
                            </div>
                            <div class="col-9">
                                <div class="pt-4 px-2">
                                    <img src="{{ asset('template/images/ic_share.png') }}" alt="">
                                    <h6 class="fs-6 fw-bold pt-3">Share untuk Dapatkan Penggemar</h6>
                                    <p class="">Bagikan link streaming kamu ke banyak channel media sosial untuk dapatkan banyak penggemar!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4 position-relative" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="2000">
                    <div class="card card-omg-how my-3 shadow border-0 card-dark">
                        <div class="row g-0">
                            <div class="col-3">
                                <img src="{{ asset('template/images/3.png') }}" class="step-number step-3 position-absolute" alt="">
                            </div>
                            <div class="col-9 ">
                                <div class="pt-4 px-2">
                                    <img src="{{ asset('template/images/ic_uang.png') }}" alt="">
                                    <h6 class="fs-6 fw-bold pt-3">Cairkan Tip</h6>
                                    <p class="">Kamu bisa say Hi ke penggemar sekaligus mencairkan tip dari mereka ke banyak pilihan e-wallet yang kamu punya.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment -->
    <section class="section section-odd card-deep-dark">
        <div class="container" data-aos="zoom-in-up">
            <div class="d-none d-md-block d-lg-block col-lg-6 col-md-9 mx-auto">
                <h3 class="text-center text-judul  text-primary fw-bold" style="margin-bottom: 40px; position: relative !important;">
                    Mendukung banyak metode tipping
                    <div class="position-absolute" style="left: 0; right: 20px; top: 20px; ">
                        <img src="{{ asset('template/images/crinkle-green.svg') }}" class="img-fluid " alt="">
                    </div>
                    <div class="position-absolute hide" style="right: 70px; top: -20px;  z-index: -1;">
                        <img src="{{ asset('template/images/circle-light purple.svg') }}" class="img-fluid asset-circle-purple" alt="">
                    </div>
                </h3>
            </div>
            <div class="col-sm-12 d-lg-none d-md-none px-0 mx-auto">
                <h3 class="text-center text-judul  text-primary fw-bold mt-3" style="margin-bottom: 40px; position: relative !important; font-size: 18px;">
                    Mendukung banyak metode tipping
                    <div class="position-absolute" style="left: 30px;  top: -40px; ">
                        <img src="{{ asset('template/images/ellips.svg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="position-absolute" style="left: 0; right: 20px; top: 20px; ">
                        <img src="{{ asset('template/images/crinkle-green.svg') }}" class="img-fluid icon-hide" alt="">
                    </div>
                    <div class="position-absolute hide" style="right: 10px; top: -20px;  z-index: -1;">
                        <img src="{{ asset('template/images/circle-light purple.svg') }}" class="img-fluid asset-circle-purple" alt="">
                    </div>
                </h3>
            </div>
            <div class="card card-payment border border-info rounded-small card-dark">
                <div class="row">
                    <div class="col-12 px-5 py-4">
                        <p class="text-center fs-5">
                            Kami sediakan berbagai macam metode bayar agar penggemar semakin mudah memberikan apresiasinya untuk karyamu. Yuk, dapatkan penggemar sebanyak yang kamu mau. Cuma di OMG.ID, Cara Fun Cari Dukungan!
                        </p>
                        <div class="card-pay px-lg-5 px-md-3 px-0">
                            <div class="col d-none d-md-block">
                                <img src="{{ asset('template/images/payment-channel.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="col d-md-none d-sm-block">
                                <img src="{{ asset('template/images/payment-channel-mobile.png') }}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('template/images/half-primary.svg') }}" class="img-fluid position-absolute" alt="" style="bottom: -100px; right: 0; z-index: -1;">
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section section-even pb-5 mb-0 card-deep-dark">
        <div class="container position-relative mb-5">
            <div class="col d-none d-lg-block">
                <img src="{{ asset('template/images/halfbold.png') }}" class="position-absolute" width="200" alt="" style="top: 200px; right: 0px; z-index: 0;">
            </div>
            <div class="col d-lg-none">
                <img src="{{ asset('template/images/capsule-mobile.svg') }}" class=" position-absolute  " alt="" style="top: 90px; left: 0px; z-index: -1;">
            </div>
            <div class="col d-none d-lg-block">
                <img src="{{ asset('template/images/half-bold.svg') }}" class="img-fluid position-absolute" alt="" style="bottom: -90px; left: 0; z-index: 0;">
            </div>
            <div class="col d-lg-none">
                <img src="{{ asset('template/images/capsule-mobile-red.svg') }}" class=" position-absolute" alt="" style="bottom: -70px; right: 0px; z-index: 0;">
            </div>
            <div class="row">
                <div class="judul how" data-aos="zoom-in-down" data-aos-duration="800">
                    <div class="col-lg-6 col-md-9 d-none d-md-block d-lg-block col-sm-12 mx-auto px-0 mb-5">
                        <h3 class="text-center text-judul  text-primary fw-bold pt-2" style="position: relative !important;">
                            Frequently Asked Question (FAQ)
                            <div class="position-absolute" style="right: 90px; top: 30px; ">
                                <img src="{{ asset('template/images/crinkle-red.svg') }}" class="img-fluid" alt="">
                            </div>
                        </h3>
                    </div>
                    <div class="col-lg-4 col-md-3 d-md-none d-lg-none col-sm-12 mx-auto px-0 mb-5">
                        <h3 class="text-center  text-primary fw-bold py-4" style="position: relative !important; font-size: 18px !important;  ">
                            Frequently Asked Question (FAQ)
                            <div class="position-absolute" style="right: 20px; top: 40px; ">
                                <img src="{{ asset('template/images/crinkle-red.svg') }}" class="img-fluid icon-hide" alt="">
                            </div>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 position-relative">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item mb-3 shadow-sm shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Apa sih OMG.ID?
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">OMG.ID merupakan platform dimana para kreator konten, live streamer, virtual youtuber, gamer, storyteller, musician, dsb bisa mendapatkan dukungan finansial dari penggemarnya dengan cara asik dan simple! Selain bisa berinteraksi dengan penggemar, para kreator juga akan mendapatkan reward & apresiasi berupa donasi uang.</div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Siapa saja yang bisa membuat akun di OMG.ID?
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">OMG.ID membuka kesempatan sebesar-besarnya untuk para livestreamer dalam mengekspresikan karyanya mulai dari streaming sambil bermain game, tutorial, reviewer, podcast, talkshow, dsb selama platform tersebut bisa kamu share untuk mendapatkan dukungan di OMG.ID.</div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button text-primary fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Platform live streaming apa saja yang didukung oleh OMG.ID?
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">OMG dapat digunakan pada software broadcasting yang menawarkan fitur 'Browser Source' seperti Streamlabs, OBS Studio, SLOBS, dll. Anda bebas menggunakan media streaming apapun seperti Youtube, Facebook, Instagram, Tiktok, Twitch, NimoTV, Cube TV, Youtube Gaming, Omlet Arcade, dll</div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="flush-heading4">
                                <button class="accordion-button collapsed text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
                                    Dimana dana tip disimpan?
                                </button>
                            </h2>
                            <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <p>
                                        Tip yang diberikan oleh penggemarmu akan tersimpan di saldo akun OMG kamu dan dapat dicairkan kapanpun.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 position-relative">
                    <div class="accordion accordion-flush" id="accordionFlushExample2">
                        <div class="accordion-item mb-3 shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    Berapa lama proses pencairan dana?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <p>
                                        Tip yang sudah masuk ke akun mu bisa dicairkan kapanpun ke e-wallet yang kamu punya.
                                        Pencairan dana paling cepat 1x24 jam (menyesuaikan payment gateway yang dipilih)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    Berapa dana minimal donasi?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <p>
                                        Anda bebas bedonasi berapapun, namun tidak menutup kemungkinan kreator memberikan tip minimun untuk berdonasi melalui item tip yang diaktifkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="heading6">
                                <button class="accordion-button collapsed text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    Berapa dana minimum yang dapat saya cairkan?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <p>
                                        Kreator dapat mencairkan dana tip dari penggemar minimal Rp 50.000 ke e-wallet yang dimiliki. Setiap pencairan dana ke rekening e-wallet akan dikenakan potongan sebesar Rp 5.000;- + PPN
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 shadow-sm" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="accordion-header" id="heading7">
                                <button class="accordion-button collapsed text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                    Apa saja yang dipotong dari tip yang saya dapatkan?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <p>
                                        Tip akan dipotong biaya platform sebesar 2% serta potongan dari payment gateway (berbeda-beda tergantung payment method, misal: GOPAY: 2%). Kamu bisa lihat informasi lebih lengkap di <a href="https://www.xendit.co/id/biaya/" target="__blank">Xendit Payments.</a> atau <a href="https://midtrans.com/id/pricing" target="__blank">Midtrans Pricing.</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection
