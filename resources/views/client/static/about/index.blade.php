@extends('layouts.template-home')

@section('title', __('Tentang'))

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
                <h1 class="text-white fw-semibold" data-aos="zoom-in-right" data-aos-duration="1000">Apa itu OMG.ID? </h1>
            </div>
        </div>
    </section>

    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12 fs-5 px-lg-5 px-3" data-aos="zoom-in-up" data-aos-duration="1000">
                    <p>OMG.ID adalah perusahaan yang berdiri di bidang teknologi dan industri kreatif. OMG.ID memiliki misi untuk memberikan kemudahan bagi kreator dan bagi siapa saja yang ingin mendapatkan apresiasi karya secara finansial.</p>
                    <p>OMG.ID merupakan sebuah layanan untuk membantu user mendapatkan dukungan karya secara finansial dari penikmat karya user. Dukungan bersifat sekali putus (bukan langganan) dan dapat dilengkapi dengan fitur-fitur yang dapat menggugah minat pendukung user.</p>
                    <p>OMG.ID bukan platform online untuk live streaming, namun platform pendukung live streaming. OMG.ID dapat digunakan pada platform live streaming yang sudah ada dan sering digunakan seperti Youtube, Facebook, Instagram, Tiktok, Twitch, NimoTV, CubeTV, Streamlabs, Youtube Gaming, Facebook Gaming, Omlet Arcade, OBS Studio, Mixer, dll. </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection
