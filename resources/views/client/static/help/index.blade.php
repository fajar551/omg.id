@extends('layouts.template-home')

@section('title', __('Bantuan'))

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
                <h1 class="text-white fw-semibold" data-aos="zoom-in-right" data-aos-duration="1000">@lang('Bantuan') </h1>
            </div>
        </div>
    </section>

    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative">
            <div class="row px-lg-5 px-3" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="col-lg-4 col-md-12 col-sm-12 mt-md-0 mt-4">
                    <div class="list-group rounded-small shadow card-dark" id="list-tab" role="tablist">
                        <button type="button" class="list-group-item list-group-item-action active" aria-current="true" id="list-faq-list" data-bs-toggle="list" href="#list-faq" role="tab" aria-controls="list-faq">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">FAQ</div>
                                    Pertanyaan Umum
                                </div>
                                <span class="badge bg-primary rounded-pill">5</span>
                            </li>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" aria-current="false" id="list-payment-list" data-bs-toggle="list" href="#list-payment" role="tab" aria-controls="list-payment">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Payment</div>
                                    Tentang pembayaran
                                </div>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" aria-current="false" id="list-supporter-list" data-bs-toggle="list" href="#list-supporter" role="tab" aria-controls="list-supporter">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Supporter</div>
                                    Seputar supporter
                                </div>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" aria-current="false" id="list-bank-account-list" data-bs-toggle="list" href="#list-bank-account" role="tab" aria-controls="list-bank-account">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Rekening Bank</div>
                                    Atur akun pencairan
                                </div>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" aria-current="false" id="list-disbursement-list" data-bs-toggle="list" href="#list-disbursement" role="tab" aria-controls="list-disbursement">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Disbursement</div>
                                    Penarikan dan pencairan dana
                                </div>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                        </button>
                        {{-- TODO: Need CW --}}
                        <button type="button" class="list-group-item list-group-item-action disabled" aria-disabled="true" aria-current="false">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Dukungan</div>
                                    Panduan memberikan dukungan
                                </div>
                                <span class="badge bg-primary rounded-pill">0</span>
                            </li>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action disabled" aria-disabled="true" aria-current="false">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Kreator</div>
                                    Seputar kreator
                                </div>
                                <span class="badge bg-primary rounded-pill">0</span>
                            </li>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action disabled" aria-disabled="true" aria-current="false">
                            <li class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Konten dan Karya</div>
                                    Tentang konten dan karya
                                </div>
                                <span class="badge bg-primary rounded-pill">0</span>
                            </li>
                        </button>
                    </div>
                    <div class="card rounded-small bg-info border-primary mt-4 d-none d-lg-block" id="card-help">
                        <div class="card-body">
                            <div class="d-flex gap-3 mb-2">
                                <img src="{{ asset('template/images/idea.svg') }}" class="icon-50" alt="idea">
                                <h5 class="text-primary text-primary-bold">Tidak menemukan jawaban?</h5>
                            </div>
                            <p>Jika anda memiliki pertanyaan seputar penggunaan platform OMG.ID silahkan hubungi kami di <a href="mailto:info@omg.id">info@omg.id</a> atau klik tombol di bawah. </p>
                            <div class="w-100 d-flex justify-content-center">
                                <a href="mailto:info@omg.id" class="btn btn-sm btn-primary rounded-pill w-100">Hubungi Kami</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 mt-lg-0 mt-md-4 mt-4">
                    <div class="card rounded-small shadow card-dark">
                        <div class="card-body">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="list-faq" role="tabpanel" aria-labelledby="list-faq-list">
                                    <h3 class="fw-semibold mb-3">FAQ</h3>
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button shadow-sm text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                    Apa sih OMG.ID?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">OMG.ID merupakan platform dimana para kreator konten, live streamer, virtual youtuber, gamer, storyteller, musician, dsb bisa mendapatkan dukungan finansial dari penggemarnya dengan cara asik dan simple! Selain bisa berinteraksi dengan penggemar, para kreator juga akan mendapatkan reward & apresiasi berupa donasi uang.</div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="flush-headingTwo">
                                                <button class="accordion-button shadow-sm collapsed text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                    Siapa saja yang bisa membuat akun di OMG.ID?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">OMG.ID membuka kesempatan sebesar-besarnya untuk para livestreamer dalam mengekspresikan karyanya mulai dari streaming sambil bermain game, tutorial, reviewer, podcast, talkshow, dsb selama platform tersebut bisa kamu share untuk mendapatkan dukungan di OMG.ID.</div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="flush-headingThree">
                                                <button class="accordion-button shadow-sm collapsed text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                    Platform live streaming apa saja yang didukung oleh OMG.ID?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">OMG dapat digunakan pada software broadcasting yang menawarkan fitur 'Browser Source' seperti Streamlabs, OBS Studio, SLOBS, dll. Anda bebas menggunakan media streaming apapun seperti Youtube, Facebook, Instagram, Tiktok, Twitch, NimoTV, Cube TV, Youtube Gaming, Omlet Arcade, dll</div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="flush-heading4">
                                                <button class="accordion-button shadow-sm collapsed text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
                                                    Dimana dana tip disimpan?
                                                </button>
                                            </h2>
                                            <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">
                                                    <p>
                                                        Tip yang diberikan oleh penggemarmu akan tersimpan di saldo akun OMG kamu dan dapat dicairkan kapanpun.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="heading4">
                                                <button class="accordion-button shadow-sm collapsed text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                    Berapa lama proses pencairan dana?
                                                </button>
                                            </h2>
                                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">
                                                    <p>
                                                        Tip yang sudah masuk ke akun mu bisa dicairkan kapanpun ke e-wallet yang kamu punya.
                                                        Pencairan dana paling cepat 1x24 jam (menyesuaikan payment gateway yang dipilih)
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="heading5">
                                                <button class="accordion-button shadow-sm collapsed text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                    Berapa dana minimal donasi?
                                                </button>
                                            </h2>
                                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">
                                                    <p>
                                                        Anda bebas bedonasi berapapun, namun tidak menutup kemungkinan kreator memberikan tip minimun untuk berdonasi melalui item tip yang diaktifkan.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="heading6">
                                                <button class="accordion-button shadow-sm collapsed text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                                    Berapa dana minimum yang dapat saya cairkan?
                                                </button>
                                            </h2>
                                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">
                                                    <p>
                                                        Kreator dapat mencairkan dana tip dari penggemar minimal Rp 50.000 ke e-wallet yang dimiliki. Setiap pencairan dana ke rekening e-wallet akan dikenakan potongan sebesar Rp 5.000;- + PPN
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="heading7">
                                                <button class="accordion-button shadow-sm collapsed text-primary fw-semibold rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                    Apa saja yang dipotong dari tip yang saya dapatkan?
                                                </button>
                                            </h2>
                                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body shadow-sm rounded-bottom">
                                                    <p>
                                                        Tip akan dipotong biaya platform sebesar 2% serta potongan dari payment gateway (berbeda-beda tergantung payment method, misal: GOPAY: 2%). Kamu bisa lihat informasi lebih lengkap di <a href="https://www.xendit.co/id/biaya/" target="__blank">Xendit Payments.</a> atau <a href="https://midtrans.com/id/pricing" target="__blank">Midtrans Pricing.</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="list-payment" role="tabpanel" aria-labelledby="list-payment-list">
                                    <h3 class="fw-semibold mb-3">Payment</h3>
                                    <ol>
                                        <li>Qris</li>
                                        <li>Gopay</li>
                                        <ul>
                                            <li>Pilih metode pembayaran Gopay</li>
                                            <li>Aplikasi Gojek akan otomatis terbuka dan menampilkan halaman Review Payment</li>
                                            <li>Periksa detail pembayaran pada aplikasi Gojek lalu klik tombol ‘Bayar’</li>
                                        </ul>
                                        <li>Ovo</li>
                                        <ul>
                                            <li>Pilih metode pembayaran OVO</li>
                                            <li>Masukkan nomor handphone yang terdaftar pada akun OVO</li>
                                            <li>Pastikan aplikasi OVO sudah terpasang pada perangkat Anda</li>
                                            <li>Konfirmasi pembayaran pada aplikasi OVO dalam waktu 30 detik</li>
                                        </ul>
                                        <li>ShopeePay</li>
                                        <ul>
                                            <li>Pilih metode pembayaran ShopeePay</li>
                                            <li>Pilih menu transfer</li>
                                        </ul>
                                        <li>LinkAja</li>
                                        <ul>
                                            <li>Pilih metode pembayaran LinkAja</li>
                                            <li>Masukkan nomor handphone yang terdaftar pada akun LinkAja</li>
                                            <li>Masukkan kode OTP yang dikirim oleh LinkAja melalui SMS ke nomor handphone Anda</li>
                                            <li>Konfirmasi pembayaran</li>
                                        </ul>
                                        <li>Mandiri</li>
                                        <li>Bni</li>
                                        <li>Mandiri</li>
                                        <li>Bri</li>
                                        <li>Permata</li>
                                        <li>Visa</li>
                                        <li>Mastercard </li>
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="list-supporter" role="tabpanel" aria-labelledby="list-supporter-list">
                                    <h3 class="fw-semibold mb-3">Supporter</h3>
                                    <ol>
                                        <li>Apa itu supporter?</li>
                                        <ul>
                                            <li>Supporter adalah user yang memberikan dukungan berupa apresiasi finansial kepada konten kreator melalui OMG.ID</li>
                                        </ul>
                                        <li>Bagaimana cara melakukan donasi?</li>
                                        <ul>
                                            <li>Supporter dapat memberikan dukungan kepada kreator dengan mengunjungi halaman kreator yang akan diberikan dukungan. Kemudian, melengkapi form supporter, dan melakukan pembayaran.</li>
                                        </ul>
                                        <li>Apa saja metode pembayaran yang dapat dilakukan?</li>
                                        <ul>
                                            <li>Saat ini, OMG.ID sudah memberikan layanan pembayaran menggunakan Gopay, OVO, DANA, ShopeePay, dan Qris. Untuk metode pembayaran lainnya akan kami implementasikan secara bertahap.</li>
                                        </ul>
                                        <li>Berapa nominal yang harus saya transfer?</li>
                                        <ul>
                                            <li>Nominal yang harus ditransfer sesuai dengan apa yang sudah diisikan Supporter pada halaman Kreator ketika akan melakukan proses pembayaran.</li>
                                        </ul>
                                        <li>Apa saya harus mendaftar dahulu untuk bisa memberikan donasi?</li>
                                        <ul>
                                            <li>
                                                Tidak harus anda dapat memberikan donasi sebagai user guest tanpa perlu mendaftar terlebih dahulu.
                                            </li>
                                        </ul>
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="list-bank-account" role="tabpanel" aria-labelledby="list-bank-account-list">
                                    <h3 class="fw-semibold mb-3">Rekening Bank </h3>
                                    <ol>
                                        <li>Bagaimana cara untuk menambahkan rekening bank?</li>
                                        <ul>
                                            <li>Untuk menambahkan rekening, dapat dilakukan pada halaman <a href="{{ route('balance.index') }}" target="_blank">Balance</a></li>
                                        </ul>
                                        <li>Berapa lama proses verifikasi rekening bank?</li>
                                        <ul>
                                            <li>Untuk proses verifikasi rekening bank memerlukan waktu 1x24 jam hari kerja</li>
                                        </ul>
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="list-disbursement" role="tabpanel" aria-labelledby="list-disbursement-list">
                                    <h3 class="fw-semibold mb-3">Disbursement</h3>
                                    <ol>
                                        <li>Apa itu disbursement?</li>
                                        <ul>
                                            <li>Disbursement merupakan proses pemindahan saldo pada akun OMG.ID ke akun bank kreator (penarikan/pencairan)</li>
                                        </ul>
                                        <li>Bagaimana proses disbursement dilakukan?</li>
                                        <ul>
                                            <li>Untuk melakukan proses disbursement Kreator harus melakukan pengaturan akun bank pada akun OMG.ID terlebih dahulu. Pastikan akun bank benar dan telah terverifikasi oleh sistem. Selanjutnya, Kreator dapat melakukan permintaan disbursement dengan memasukkan nominal jumlah dana yang ingin dicairkan dan menunggu proses disbursement.</li>
                                        </ul>
                                        <li>Berapa batas nominal disbursement?</li>
                                        <ul>
                                            <li>Untuk saat ini, batas nominal disbursement dalam satu kali disbursement:</li>
                                            <ul>
                                                <li>Minimal Rp 50.000 dengan potongan biaya admin Rp 5.000</li>
                                            </ul>
                                        </ul>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 mt-lg-0 mt-md-4 mt-4 d-lg-none d-md-block">
                    <div class="card rounded bg-info border-primary ">
                        <div class="card-body">
                            <div class="d-flex gap-3 mb-2">
                                <img src="{{ asset('template/images/idea.svg') }}" class="icon-50" alt="idea">
                                <h5 class="text-primary">Tidak menemukan jawaban?</h5>
                            </div>
                            <p>Jika anda memiliki pertanyaan seputar penggunaan platform OMG.ID silahkan hubungi kami di <a href="mailto:info@omg.id">info@omg.id</a> atau klik tombol di bawah. </p>
                            <div class="w-100 d-flex justify-content-center">
                                <a href="mailto:info@omg.id" class="btn btn-sm btn-primary rounded-pill w-50 w-sm-100">Hubungi Kami</a>
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
