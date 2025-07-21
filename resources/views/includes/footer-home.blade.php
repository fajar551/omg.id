<div class="col-12 d-none d-md-block d-lg-block bg-light pt-5 pb-1">
    <footer class="container pt-4 footer bg-white shadow position-relative rounded-top">
        {{-- <img src="{{ asset('template/images/shape.svg') }}" class="img-fluid position-absolute  " alt="" id="shape-bntg" style="top: -25px;"> --}}
        <img src="{{ asset('template/images/pillfot1.svg') }}" class="img-fluid position-absolute d-none d-md-block" alt="" style="top: -30px; left: 25rem ;">

        <div class="row ">
            <div class="col-md-8 col-sm-12 mx-auto mt-4">
                <div class="border-0 ">
                    <div class="card-body mt-4">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 mx-auto">
                                <div class="navbar-brand text-warning d-flex align-items-center gap-2">
                                    <a href=" {{ url('/') }} " class="text-center" href="#">
                                        <img src="{{ asset('template/images/omg.png') }}" alt="" class=" " width="30" height="30">
                                    </a>
                                    <span class="fw-bold d-none d-md-flex text-primary">OMG</span>
                                </div>
                                <p class="text-sm" style="text-align: left;">Tempatnya para kreator bisa #DAPATTIP dari para penggemarnya sebagai apresiasi karya melalui live streaming</p>
                                <a href="https://www.instagram.com/omg_id_/" target="_blank" class="text-primary" id="footer-text-ig">
                                    <img src="{{ asset('template/images/instagram.png') }}" alt="" width="30" class="footer-image-ig" height="30"> @omg_id_
                                </a>
                            </div>
                            <div class="col-md-4 col-6 mt-4 mt-md-0 ps-0 ps-md-5">
                                <div class="d-flex">
                                    <div class="">
                                        <h5 class="fw-semibold">Informasi</h5>
                                        <ul class="nav d-flex flex-column">
                                            <li class="nav-item text-sm mb-2">
                                                <a class="text-dark" href="{{ route('pages.about') }}  "> Tentang OMG </a>
                                            </li>
                                            <li class="nav-item text-sm mb-2">
                                                <a class="text-dark" href="{{ route('pages.help') }}"> Bantuan </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex ps-0" id="foot-contact">
                                    <div class="ms-0">
                                        <h5 class="fw-semibold">Hubungi Kami</h5>
                                        <ul class="nav d-flex flex-column">
                                            {{-- <li class="nav-item text-sm mb-2">
                                                    Blog
                                                </li> --}}
                                            <li class="nav-item text-sm mb-2">
                                                <a class="text-dark" href="https://forms.gle/zCSyPf1Qufk95JXt6" target="_blank"> Kritik dan Saran </a>
                                            </li>
                                            <li class="nav-item text-sm mb-2">
                                                <a class="text-dark" href="https://forms.gle/Po44HUUnc7v49kcC8" target="_blank"> Survei </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mt-4 mt-md-0">
                                <div class="">
                                    <div class="mx-0 mx-md-auto ms-auto">
                                        <h5 class="fw-semibold">Produk</h5>
                                        <ul class="nav d-flex flex-column">
                                            <li class="nav-item text-sm mb-2">
                                                <a class="text-dark" href="{{ route('explore.index') }}  "> Explore Kreator </a>
                                            </li>
                                            <li class="nav-item text-sm mb-2">
                                                <a class="text-dark" href="{{ route('register') }}  "> Buat Halaman </a>
                                            </li>
                                            <li class="nav-item text-sm mb-2">
                                                <a class="text-dark" href="{{ route('pages.feature') }}  "> Fitur dan Harga </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('template/images/44.svg') }}" class="img-fluid position-absolute d-none d-md-block" alt="" style="bottom: 80px; right: -30px; ">
            </div>
            <div class="col-12 p-3 d-flex justify-content-between align-items-center" style="z-index: 1;">
                <div class="d-flex justify-content-start align-items-center">
                    <a href="{{ route('pages.termofservice') }}" class="text-dark">Terms and conditions</a>
                    <span class="h3 text-primary mb-0 mx-2">&bull;</span>
                    <a href="{{ route('pages.privacypolice') }}" class="text-dark">Privacy Policy</a>
                </div>
                <div class="credits"> <a href="/" class="copyright"> <span class="text-dark">&copy; Copyright</span> <strong>{{ env('APP_NAME', 'OMG.ID Dev ') }}</strong></a></div>
            </div>
        </div>
    </footer>
</div>
<div class="p-3 d-md-none d-lg-none bg-light" style="overflow: hidden;">
    <div class="row  d-flex justify-content-center position-relative card-dark" style=" margin-top: 80px; border-radius: 30px 30px 0px 0px; background: #FFFFFF; box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.15); padding: 30px 50px; ">
        <img src="{{ asset('template/images/star-red.svg') }}" class=" position-absolute  " width="100" height="90" alt="" style="top: -50px; right: 8rem ;">
        <img src="{{ asset('template/images/capsule-green.svg') }}" class=" position-absolute  " width="80" height="80" alt="" style="bottom: -50px; left: 2rem ;">
        <div class="col-12">
            <div class="row my-2">
                <div class="col-3">
                    <div class="text-warning d-flex align-items-center gap-2">
                        <a href=" {{ url('/') }} " class="text-center" href="#">
                            <img src="{{ asset('template/images/omg.png') }}" alt="" class=" " width="70">
                        </a>
                        {{-- <span class="fw-bold d-flex">OMG</span> --}}
                    </div>
                </div>
                <div class="col-9 ps-5">
                    <p class="text-sm">Tempatnya para kreator bisa #DAPATTIP dari para penggemarnya sebagai apresiasi karya melalui live streaming</p>
                </div>
            </div>
        </div>
        <div class=" col-5 px-0 mx-0 ">
            <p class="mb-2 parent-judul fw-semibold">Produk </p>

            <ul class="nav d-grid flex-item">
                <!-- <li class="nav-item mb-2 parent-judul fw-semibold">Produk</li> -->
                <li class="nav-item text-sm list-sub-judul ">
                    <a class="text-dark" href="{{ route('explore.index') }}  "> Explore </a>
                </li>
                <li class="nav-item text-sm  list-sub-judul">
                    <a class="text-dark" href="{{ route('register') }}  "> Buat Halaman </a>
                </li>
                <li class="nav-item text-sm list-sub-judul">
                    <a class="text-dark" href="{{ route('pages.feature') }}  "> Fitur dan Harga </a>
                </li>
            </ul>
        </div>
        <div class=" col-5">
            <p class="mb-2 parent-judul fw-semibold">Informasi</p>
            <ul class="nav d-grid flex-item">
                <!-- <li class="nav-item mb-2 ">Informasi</li> -->
                <li class="nav-item text-sm list-sub-judul ">
                    <a class="text-dark" href="{{ route('pages.about') }}">Bantuan</a>
                </li>
                <li class="nav-item text-sm list-sub-judul ">
                    <a class="text-dark" href=" {{ route('pages.termofservice') }} "> @lang('page.terms_and_condition') </a>
                </li>
                <li class="nav-item text-sm  list-sub-judul">
                    <a class="text-dark" href="{{ route('pages.privacypolice') }}">@lang('page.privacy_police')</a>
                </li>
                <li class="nav-item text-sm list-sub-judul ">
                    <a class="text-dark" href="{{ route('pages.help') }}">Bantuan</a>
                </li>
            </ul>
        </div>

        <div class="row mt-4">
            <div class="col-6">
                <p class="mb-2 parent-judul fw-semibold">Hubungi Kami </p>
                <ul class="nav d-grid flex-column flex-item">
                    {{-- <li class="nav-item text-sm list-sub-judul "> 
                        Blog 
                    </li> --}}
                    <li class="nav-item text-sm list-sub-judul ">
                        <a class="text-dark" href="https://forms.gle/zCSyPf1Qufk95JXt6" target="_blank"> Kritik dan Saran </a>
                    </li>
                    <li class="nav-item text-sm list-sub-judul ">
                        <a class="text-dark" href="https://forms.gle/Po44HUUnc7v49kcC8" target="_blank"> Survei </a>
                    </li>
                </ul>
            </div>
            <div class="col-6">
                <h6 class="nav-item fw-bold parent-judul">
                    Social Media
                </h6>
                <div class="nav d-flex text-center mb-2">
                    {{-- <li class="nav-item text-sm">
                        <a href="#">
                            <img src="{{ asset('template/images/fb.png') }}" alt="" width="30" height="30">
                        </a>
                    </li>
                    <li class="nav-item text-sm">
                        <a href="#">
                            <img src="{{ asset('template/images/twitter.png') }}" class="mx-2" alt="" width="30" height="30">
                        </a>
                    </li> --}}
                    <li class="nav-item text-sm">
                        <a href="https://www.instagram.com/omg_id_/" target="_blank">
                            <img src="{{ asset('template/images/instagram.png') }}" class="footer-image-ig" alt="" width="30" height="30">
                        </a>
                    </li>
                </div>
                {{-- <div class="mt-3">
                    <img src="{{ asset('template/images/logo-arrow.png') }}" alt="" height="30">
                </div> --}}
            </div>
        </div>
    </div>
</div>
