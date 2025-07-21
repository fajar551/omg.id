@extends('layouts.template-home')

@section('title', __('page.terms_and_condition'))

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
                <h1 class="text-white fw-semibold" data-aos="zoom-in-right" data-aos-duration="1000">@lang('page.terms_and_condition') </h1>
            </div>
        </div>
    </section>

    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12 fs-5 px-lg-5 px-3" data-aos="zoom-in-up" data-aos-duration="1000">
                    <p>
                        Hai OMG fellas! Pada halaman ini, akan diberikan informasi mengenai syarat dan ketentuan dari penggunaan situs web dan platform www.omg.id baik untuk kreator maupun penggemar. Harap untuk dibaca dengan cermat agar semua mendapatkan keuntungan dari platform omg.id dengan sempurna!
                    </p>
                    <p>
                        Seluruh pengunjung yang mengunjungi dan/atau menggunakan platform OMG.ID, maka dinyatakan telah menyetujui dan memahami semua syarat dan ketentuan yang terlampir di bawah ini. Jika Anda tidak menyetujui atau melanggar sebagian atau seluruh isi dari syarat dan ketentuan penggunaan ini, maka Anda tidak diperkenankan untuk menggunakan platform OMG.ID.
                    </p>
                    <p class="fw-semibold">
                        Services
                    </p>
                    <p>
                        OMG.ID merupakan platform dimana para kreator konten, live streamer, virtual youtuber, gamer, storyteller, musician, dsb bisa memonetisasi hasil karya mereka di platform video streaming pihak ketiga dan mendapatkan dukungan finansial dari penggemarnya dengan cara asik dan simple! Selain bisa berinteraksi dengan penggemar, para kreator juga akan mendapatkan reward & apresiasi berupa donasi uang.
                    </p>

                    <p class="fw-semibold">
                        Kreator
                    </p>

                    <p>
                        Kreator yang dimaksud pada platform OMG.ID adalah pengguna yang telah mendaftarkan akun di OMG.ID dan memiliki tujuan untuk menerima dukungan, mendapat donasi, dan fitur lainnya yang ada pada halaman kreator.
                    </p>

                    <p class="fw-semibold">
                        Hak dan Kewajiban Kreator
                    </p>

                    <ul>
                        <li>Kreator wajib mendaftarkan dirinya menggunakan email aktif. Mengisi informasi akurat, dengan minimal usia 18 tahun ketika melakukan proses pendaftaran atau telah memiliki izin wali yang bersangkutan.</li>
                        <li>Data tersebut digunakan untuk memverifikasi Kreator dan hanya akan digunakan untuk keperluan korespondensi dengan tim OMG.ID, dan dengan pihak terkait yang telah disetujui oleh Kreator. </li>
                        <li>Kreator tidak dibatasi dalam membuat akun dan mengakses platform OMG.ID selama kreator bertanggung jawab penuh akan konten yang disebarkan melalui pihak ketiga dan melibatkan OMG.ID sebagai media penerima dukungan. Konten tidak boleh melanggar aturan dan hukum di Indonesia.</li>
                        <li>Kreator bertanggung jawab atas keamanan akun dan segala hal yang terjadi pada akun Kreator selama menggunakan situs OMG.ID.</li>
                        <li>Kreator tidak menggunakan platform OMG.ID untuk penggalangan dana sebagai dukungan politik, keperluan organisasi massa dengan afiliasi pada pihak pelanggar hukum, atau dengan niat melakukan tindakan melanggar hukum.</li>
                        <li>Kreator diperbolehkan menginformasikan hasil karya atau konten pada platform lain</li>
                        <li>Akun Kreator tidak dapat diperjualbelikan atau dipindahtangankan.</li>
                        <li>Kreator tidak diperkenankan menggunakan layanan OMG.ID untuk tujuan ilegal atau tidak sah yang dapat melanggar ketentuan hukum di Indonesia. </li>
                        <li>Kreator tidak boleh mentransmisikan worm atau virus atau kode apapun yang bersifat merusak. Pelanggaran atau pelanggaran terhadap salah satu ketentuan ini akan mengakibatkan penghentian penggunaan layanan OMG.ID.</li>
                        <li>Kreator menyetujui untuk tidak memproduksi, menggandakan, menyalin, menjual, menjual kembali, atau mengeksploitasi setiap bagian dari layanan-layanan yang diberikan OMG.ID, penggunaan layanan-layanan OMG.ID, atau akses ke layanan OMG.ID atau kontak apapun yang tersedia, tanpa izin tertulis dari OMG.ID</li>
                        <li>Kewajiban pajak yang timbul baik sekarang maupun di masa yang akan datang, sepenuhnya menjadi tanggung jawab masing-masing pihak yang melakukan transaksi melalui penggunaan layanan OMG.ID. Termasuk tanggung jawab untuk menilai, mengumpulkan, melaporkan atau mengirimkan informasi pajak otoritas yang berwenang sesuai dengan ketentuan perpajakan yang berlaku di Indonesia
                        </li>
                    </ul>

                    <p class="fw-semibold">
                        Penggemar
                    </p>
                    <p>
                        Penggemar merupakan pihak yang memberikan dukungan dan donasi kepada Kreator. Penggemar dapat menikmati live streaming Kreator yang dapat diakses dari platform pihak ketiga sesuai dengan yang digunakan kreator.
                    </p>


                    <h3 class="fw-semibold  mb-4 mt-4">Hak dan kewajiban penggemar</h3>


                    <ol>
                        <li>
                            Penggemar wajib mendaftarkan dirinya menggunakan email aktif. Mengisi informasi akurat, dengan minimal usia 18 tahun ketika melakukan proses pendaftaran atau telah memiliki izin wali yang bersangkutan.
                        </li>
                        <li>
                            Penggemar wajib mengikuti segala peraturan yang berlaku ketika menggunakan layanan-layanan OMG.ID, termasuk mengenai konten, informasi, dan transmisi elektronik.
                        </li>
                        <li>
                            Dalam memberikan dukungan kepada Kreator, Penggemar setuju dengan metode pembayaran yang dipilih dan memberikan kuasa serta wewenang penuh kepada OMG.ID untuk menagih setiap transaksi.
                        </li>
                        <li>
                            Layanan yang diberikan OMG.ID memungkinkan Penggemar untuk mengirimkan donasi melalui pihak ketiga. OMG.ID berhak untuk menambah atau menghapus donasi untuk proses pembayaran pihak ketiga setiap saat.
                        </li>
                        <li>
                            Kewajiban pajak menjadi tanggung jawab Penggemar sepenuhnya. Penggemar juga memiliki tanggung jawab untuk menilai, melaporkan, mengumpulkan, atau mengirimkan informasi pajak ke pihak yang berwenang.
                        </li>
                    </ol>




                    <p class="fw-semibold">
                        Hak dan Kewajiban OMG.ID
                    </p>
                    <p>
                        Untuk dapat memberikan layanan yang aman, nyaman, dan efektif bagi semua pengguna, OMG.ID perlu untuk menjaga seutuhnya atas apa yang terjadi pada layanan yang diberikan OMG.ID kepada penggunanya. Adapun hak dan kewajiban OMG.ID sebagai berikut:
                    </p>

                    <ol>
                        <li>
                            OMG.ID dapat mengubah semua dari layanan hingga fungsi yang terdapat pada layanan.
                        </li>
                        <li>
                            OMG.ID dapat memberhentikan sebagian atau semua layanan yang ada pada situs.
                        </li>
                        <li>
                            OMG.ID dapat mengubah kriteria kelayakan pengguna untuk mengakses layanan.
                        </li>
                        <li>
                            OMG.ID dapat menghentikan, membatasi, atau menonaktifkan akses pengguna layanan OMG.ID atau apapun yang ada pada layanan OMG.ID
                        </li>
                    </ol>

                    <p class="fw-semibold">
                        Larangan
                    </p>

                    <ol>
                        <li>
                            Pengguna tidak diperkenankan untuk melakukan aktivitas tidak wajar yang dapat mengancam keamanan platform maupun sesama pengguna situs OMG.ID.
                        </li>
                        <li>
                            Pengguna tidak diperkenankan menggunakan layanan OMG.ID untuk mendanai love streaming dengan konten yang bersifat berikut:
                            <ul>
                                <li>
                                    Pornografi, rasisme, kriminal, menyinggung SARA, konten bersifat provokatif, hingga memicu konflik antar golongan.
                                </li>
                                <li>
                                    Penipuan dan penggelapan
                                </li>
                                <li>
                                    Materi lain yang melanggar aturan hukum yang berlaku.
                                </li>
                                <li>
                                    Materi yang merupakan karya atau hak cipta dari orang lain.
                                </li>
                            </ul>
                        </li>
                        <li>
                            Bila ditemukan karya, konten atau jasa yang melanggar ketentuan tersebut, OMG.ID berhak untuk menghapus integrasi antara OMG.ID dengan pengguna. Selain itu, OMG.ID berhak menolak untuk menyediakan layanan di kemudian hari kepada setiap orang yang melanggar syarat dan ketentuan ini.
                        </li>
                        <li>
                            Anda tidak dapat melakukan klaim apapun kepada OMG.ID atas pelanggaran yang Anda lakukan terhadap syarat dan ketentuan penggunaan situs OMG.ID
                        </li>
                        <li>
                            Anda juga tidak diperkenankan untuk melakukan transaksi yang bersifat ilegal, namun tidak terbatas pada penipuan, carding, tindakan pencucian uang dan hal lainnya yang melanggar hukum yang berlaku di Indonesia.
                        </li>
                        <li>
                            Berdasarkan larangan yang telah ditetapkan, kami berhak melakukan penangguhan/pembekuan akun, pemblokiran nomor rekening/ e-wallet, pembekuan saldo dan pembatasan fitur bagi pengguna apabila terjadi pelanggaran dari larangan-larangan tersebut. OMG.ID berhak melakukan tindakan penyerahan data kepada pihak berwajib atau stakeholder terkait jika diperlukan.
                        </li>

                    </ol>

                    <p class="fw-semibold">
                        BIAYA
                    </p>
                    <p>
                        Kreator dapat mencairkan dana tip dari penggemar minimal Rp 50.000 ke e-wallet yang dimiliki. Setiap pencairan dana ke rekening e-wallet akan dikenakan potongan sebesar Rp 5.000.
                    </p>
                    <p>
                        Tip yang diberikan oleh penggemar Anda akan tersimpan di saldo akun OMG Anda dan dapat dicairkan kapanpun. Tip akan dipotong biaya penanganan sebesar 2% serta potongan dari payment gateway (berbeda-beda tergantung merchant, mis: OVO Rp 1.000)
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection
