@extends('layouts.template-body')

@section('title')
    <title>Subcription Content</title>
@endsection

@section('styles')

@endsection

@section('content')
    <div class="container px-5 ">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('Konten Dibeli'), 
                    'pages' => __('page.content')
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>

        <div class="row step1">
            @if ($content['data'])
                <div class="col-lg-12">
                    <div class="card border-0 py-4 px-md-2 px-0 rounded-small shadow card-dark">
                        <div class="row mx-3">
                            @foreach ($content['data'] as $ctn)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
                                @include('components.card-content-v2', [
                                    'content' => array_merge($ctn, ['thumbnail_path' => $ctn['thumbnail'], 'pageName' => $ctn['pageName']]), 
                                    'activeItem' => array_merge([$ctn['item'], $ctn['price']], ['icon' => $ctn['item_icon']]),
                                    'action' => 'subscribed',
                                    // 'user_id' => $user_id,
                                ])
                            </div>
                            @endforeach
                            
                            {{-- @foreach ($content['data'] as $item)
                                <div class="col-lg-3 col-sm-12 cols-sm px-md-1 px-sm my-3 mx-1">
                                    <div class="card" style="border-radius: 10px !important; min-height:280px;">
                                        <div class="position-relative" style="text-align: center">
                                            <img src="{{ $item['thumbnail'] ?: asset('template/images/bg-gradient.png') }}" class="card-img-top" alt="..." style="border-radius: 10px 10px 0px 0px !important; max-height: 150px; object-fit: cover; min-height: 150px;">
                                            <div class="bg-card-creator position-absolute" style="border-radius: 10px 10px 0px 0px !important;"></div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <p class="card-text creator my-0 text-elipsis" style="min-height: 40px;">
                                                    <span class="card-text creator my-0">{{ $item['price'] == 'Free' ? ' [Free]' : '' }}</span>
                                                    {{ $item['title'] }}
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-end" style="min-height: 50px; overflow: hidden">
                                                <a href="{{ route('creator.contentdetail', ['page_name' => $item['pageName'], 'slug' => $item['slug']]) }}" class="btn btn-primary rounded-pill btn-sm w-100 mt-2 stretched-link">
                                                    Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach --}}
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-5">
                            <div class="col-lg-5 col-sm-12">
                                @if (isset($content['data'][0]))
                                    {!! $content['pagging']['links'] !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div style="text-align: center" class="my-4">
                    <img src="{{ asset('template/images/not-found.png') }}" class="img-fluid my-2" width="40%" alt="">
                    <h6 class="text-center"> Belum ada konten yang kamu beli </h6>
                    <a href="{{ route('explore.index') }}" class="btn btn-primary rounded-pill btn-sm mt-2 w-25 w-sm-75">
                        <i class="fa fa-search"></i> Explore Kreator
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/guide/contentsubs.js') }}"></script> 
@endsection
