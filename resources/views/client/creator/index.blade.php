@extends('layouts.template-support')

@section('title', $page['name'])

@section('styles')
    <style>
    </style>
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"> --}}
@endsection
@section('content')
    <section class="section min-vh-100 bg-light m-0">
        <div class="container px-lg-5 px-3 pt-3 mt-5" data-aos="zoom-in-up" data-aos-duration="800">

            <!-- Header Cover -->
            @include('components.header-page-creator')

            <div class="row pt-4">
                {{-- Side menu page creator --}}
                @include('components.side-page-creator')

                {{-- Content --}}
                <div class="col-lg-8 d-grid align-self-start gap-3">
                    <div class="card creators rounded-small shadow border-0 p-2 mt-lg-0 mt-3 card-dark">
                        <div class="card-header bg-transparent border-0 p-1">

                            @include('components.nav-creator-mobile')

                            <div class="d-flex justify-content-between align-items-center w-100 d-none d-md-none d-lg-flex">
                                <h5 class="fw-semibold m-0">@lang('Konten Terbaru') </h5>
                                <a class="btn btn- border-0 text-right" href="{{ route('creator.content', ['page_name' => $pageName]) }}" role="button">
                                    Lihat semua
                                    <img src="{{ asset('template/images/icon/arrows.png') }}" height="30" />
                                </a>
                            </div>
                        </div>
                        <div class="card-body row" id="products-creator">
                            @if (isset($content['data'][0]))
                                @php
                                    // User auth
                                    $user_id = isset($user['id']) ? $user['id'] : null;
                                @endphp

                                @foreach ($content['data'] as $ctn)
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                                    @include('components.card-content-v2', [
                                        'content' => array_merge($ctn, ['thumbnail_path' => $ctn['thumbnail']]), 
                                        'activeItem' => array_merge([$ctn['item'], $ctn['price']], ['icon' => $ctn['item_icon']]),
                                        'action' => 'support',
                                        'user_id' => $user_id,
                                    ])
                                </div>
                                @endforeach
                                {{-- @include('components.card-content') --}}
                            @else
                                <div style="text-align: center">
                                    <img src="{{ asset('template/images/not-found.png') }}" class="img-fluid" width="100" alt="" srcset="">
                                    <h6 class="text-center"> Belum ada konten yang dibuat </h6>
                                </div>
                            @endif
                        </div>

                        <div class="row d-flex justify-content-center">
                            <div class="col-8 d-lg-none d-md-none ">
                                <button class="btn btn-outline-primary rounded-pill d-block w-100"> Lihat semua </button>
                            </div>
                        </div>

                    </div>
                    <div class="card creators rounded-small shadow border-0 p-2 card-dark">
                        <div class="card-header bg-transparent border-0 p-1">
                            <h5 class="fw-semibold m-0">Dukungan </h5>
                        </div>
                        <div class="card-body">
                            <div class="col-12" id="comment-creator">
                                @if (@$support_history['data'][0])
                                    @foreach ($support_history['data'] as $item)
                                        <div class="bg-transparent text-dark border d-block  w-100 text-start py-3 my-2 rounded-0 inner-card-dark" style="font-size: small; padding: 7px" id="message">
                                            <span class="support-message">{{ $item['support'] }}</span>
                                            @if (isset($item['message']))
                                                <span class="support-message-item">{{ ' - ' . $item['message'] }}</span>
                                            @endif <br> <span class="text-muted mt-2">{{ $item['date'] }}</span>
                                        </div>
                                    @endforeach
                                    {!! $support_history['pagging']['links'] !!}
                                @else
                                    <div style="text-align: center">
                                        <img src="{{ asset('template/images/not-found.png') }}" class="img-fluid" width="100" alt="" srcset="">
                                        <h6 class="text-center"> Belum ada dukungan </h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
@endsection
