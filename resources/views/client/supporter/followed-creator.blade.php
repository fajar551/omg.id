@extends('layouts.template-body')

@section('title')
    <title>Kreator Diikuti</title>
@endsection

@section('styles')

@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('Kreator Diikuti'), 
                    'pages' => __('Mengikuti')
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>

        <div class="row step1">
            @if (isset($data['data'][0]))
                <div class="col-lg-12 col-creator">
                    <div class="card border-0 rounded-small shadow py-4 px-md-2 px-0 card-dark">
                        <div class="row mx-3">
                            @foreach ($data['data'] as $item)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <div class="card shadow-sm shadow-hover-sm rounded-small border inner-card-dark" data-page="{{ $item['page_url'] }}" style="z-index: 99;">
                                        <img src="{{ $item['cover_image'] }}" class="card-banner banner-explore" alt="">
                                        <div class="card-body position-relative">
                                            <div class="position-absolute " style="top: -30px;">
                                                <div class="d-flex justify-content-around">
                                                    <img src="{{ $item['avatar'] }}" class="rounded-circle shadow-sm bg-white icon-80" alt="">
                                                </div>
                                            </div>
                                            <div class="position-absolute" style="top: -30px; right: 10px;">
                                                <button class="btn btn-outline-primary btn-sm text-sm rounded-pill btn-follow" id="btn-follow-{{ $item['user_id'] }}" data-id="{{ $item['user_id'] }}" style="margin-left: 60px !important; z-index: 99999; margin-top: 40px !important"> Unfollow</button>
                                            </div>
                                            <h6 class="card-title fw-bold pt-5 pb-0 mb-0 text-line-1" title="{{ $item['name'] }}">{{ $item['name'] }}</h6>
                                            <span class="text-sm text-muted text-line-1 pb-0 mb-2" title="{{ $item['page_category'] }}">{{ $item['page_category'] }}</span>
                                            {{-- <p class="text-sm pb-0 mb-0 text-line-2" style="min-height: 2.5rem; max-height: 2.5rem;" title="{{ $item['page_message'] }}">{{ $item['page_message'] }}</p> --}}
                                            <div class="d-flex justify-content-between gap-2">
                                                <span class="fw-semibold text-line-1" title="Following"> <span class="text-primary followings-count-{{ $item['user_id'] }}"> {{ Utils::kNFormatter($item['follow_info']['followings_count']) }}</span> Following</span> 
                                                <span class="fw-semibold text-line-1" title="Follower"> <span class="text-primary followers-count-{{ $item['user_id'] }}"> {{ Utils::kNFormatter($item['follow_info']['followers_count']) }}</span> Follower</span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-3 mb-5">
                            <div class="">
                                @if (isset($data['data'][0]))
                                    {!! $data['pagging']['links'] !!}
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
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/guide/followers.js') }}"></script> 
    <script>
        (function($) {
            "use strict";

            const authCheck = "{{ auth()->check() }}";

            const follow = async (id) => {
                const formData = new FormData();
                formData.append('user_id', id);

                $(`#btn-follow-${id}`).attr({"disabled": true}).html('Loading...');
                const result = await axios.post(`/api/follow`, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;
                        const { follow = false, info = '' } = result;

                        let followCountWrapper = $(`.followers-count-${id}`);
                        let followCount = parseInt(followCountWrapper.html());
                        if (follow) {
                            $(`#btn-follow-${id}`).addClass('btn-outline-primary');
                            $(`#btn-follow-${id}`).removeClass('btn-primary');
                            $(`#btn-follow-${id}`).text('Unfollow');

                            followCountWrapper.html(++followCount);
                        } else {
                            $(`#btn-follow-${id}`).removeClass('btn-outline-primary');
                            $(`#btn-follow-${id}`).addClass('btn-primary');
                            $(`#btn-follow-${id}`).text('Follow');

                            followCountWrapper.html(--followCount);
                        }

                        Toast2.fire({
                            icon: follow ? 'info' : 'warning',
                            title: follow ? 'Following' : 'Unfollowing',
                            html: info
                        });

                        return data;
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        Toast2.fire({
                            icon: 'error',
                            title: message
                        });
                    }).finally(() => {
                        $(`#btn-follow-${id}`).attr({ "disabled": false }).text($(`#btn-follow-${id}`).text());
                    });
            }

            $(document).on('click', '.btn-follow', function(e) {
                e.stopPropagation();
                if (!authCheck) {
                    Toast2.fire({
                        icon: 'warning',
                        title: 'Yuk login untuk mengikuti.'
                    });
                } else {
                    follow($(this).attr('data-id'));
                }
            });
        })(jQuery);
    </script>
@endsection
