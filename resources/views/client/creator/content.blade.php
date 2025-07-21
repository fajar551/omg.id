@extends('layouts.template-support')

@section('title', $page['name'])

@section('styles')
    <style>
    </style>
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
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-9 col-md-8 mb-2">
                                <a href="{{ route('creator.content', ['page_name' => $page['page_url'], 'category' => 'all']) }}@if (isset($order)) &order={{ $order }} @endif" class="rounded-pill btn bg-1 badge mx-1 py-2 my-1 @if ($category == 'all' || $category == false) active-badge @endif"><span style="">All</span></a>
                                @foreach ($content_category as $item)
                                    <a href="{{ route('creator.content', ['page_name' => $page['page_url'], 'category' => strtolower($item['title'])]) }}@if (isset($order)) &order={{ $order }} @endif" class="rounded-pill btn bg-1 badge mx-1 py-2 my-1 @if ($category == strtolower($item['title'])) active-badge @endif"><span style="">{{ ucwords($item['title']) }}</span></a>
                                @endforeach
                            </div>
                            <div class="col-xl-3 col-md-4">
                                <select name="order" id="order-content" class="form-select w-100 order-content">
                                    <option value="latest" @if ($order == 'latest') selected @endif>Terbaru</option>
                                    <option value="asc" @if ($order == 'asc') selected @endif>Urutan A-Z</option>
                                    <option value="desc" @if ($order == 'desc') selected @endif>Urutan Z-A</option>
                                    <option value="oldest" @if ($order == 'oldest') selected @endif>Terdahulu</option>
                                </select>
                            </div>
                        </div>                            
                        @php
                            $user_id = isset($user['id']) ? $user['id'] : null;
                        @endphp
                        <div class="row mt-2">
                            @if (isset($content['data'][1]) || isset($content['data'][0]))
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
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-5">
                        <div class="col-lg-5 col-sm-12 d-flex justify-content-center">
                            @if (isset($content['data'][0]))
                                {!! $content['pagging']['links'] !!}
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

@endsection
