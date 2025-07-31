@extends('layouts.template-home')

@section('title', __('Explore Creator'))

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('template/vendor/slick/slick.css')}}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('template/vendor/slick/slick-theme.css')}}" /> --}}
@endsection

@section('content')
    <section class="container-fluid position-relative bg-heros p-0">
        <div class="position-absolute bottom-0 start-0 w-100">
            <div class="container px-lg-5 px-3">
                <h1 class="text-white fw-semibold" data-aos="zoom-in-right" data-aos-duration="1000">Explore Creator </h1>
            </div>
        </div>
    </section>

    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative">
            <div class="row px-lg-5 px-3" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="col-lg-4 col-md-12 col-sm-12 mt-md-0 mt-4">
                    <div class="shadow rounded-small accordion bg-white" id="accordion-filter">
                        <div class="accordion-item bg-transparent border-0">
                            <div class="accordion-header" id="heading-filter">
                                <button class="accordion-button accordion-filter bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-filter" aria-expanded="true" aria-controls="collapse-filter">
                                    <h5>@lang('Filter')</h5>
                                </button>
                            </div>
                            <div id="collapse-filter" class="accordion-collapse collapse show" aria-labelledby="heading-filter" data-bs-parent="#accordion-filter">
                                <div class="accordion-body">
                                    <div class="row d-flex justify-content-center mb-3">
                                        <h6>Cari</h6>
                                        <div class="col-12 mx-1">
                                            @include('components.form-search')
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <h6>Kategori</h6>
                                        <div class="col-12 mx-1">
                                            <div class="regular d-none" id="category" style="height: 260px; overflow-y: auto;">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 mt-lg-0 mt-md-4 mt-4">
                    <div class="card rounded-small shadow min-vh-100 card-dark">
                        <div class="card-body">
                            <div class="pb-4 mb-5 px-4 py-3">
                                <div class="row d-flex align-items-center" id="cards" >
                    
                                </div>
                            </div> 
                        </div>
                        <div class="card-footer border-0 bg-transparent">
                            <div class="col-12 d-flex justify-content-center" id="links">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- <script src="{{ asset('template/vendor/slick/slick.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script>
        /**
        * Explore page script
        * Version: 1.0
        */
        (function ($) {
            "use strict";

            const user_auth_param = '{!! auth()->check() ? "&user_id=" .auth()->user()->id : '' !!}';
            const authId = "{{ auth()->check() ? auth()->user()->id : '' }}";
            const authCheck = "{{ auth()->check() }}";
            
            let currentCategory = 0;
            let searchParams = new URLSearchParams(window.location.search);
            let search = searchParams.get('keywords') || '';
            let pageNumber = 1;

            const notFoundTemplate = `
                <div class="col-lg-5 col-sm-12 d-grid justify-content-center align-items-center w-100" > 
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('template/images/not-found.png') }}" class="img-fluid icon-250" alt="">
                    </div>
                    <h4 class="text-center"> Ups! Data yang Anda cari tidak ada </h4>
                    <div class="text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary px-4 rounded-pill mt-5"> Home </a>
                    </div>
                </div>
                `;
            
            const errorTemplate = `
                <div class="col-lg-5 col-sm-12 d-grid justify-content-center align-items-center w-100" > 
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('template/images/not-found.png') }}" class="img-fluid icon-250" alt="">
                    </div>
                    <h4 class="text-center"> Ups! Ada yang salah, silakan coba lagi </h4>
                    <div class="text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary px-4 rounded-pill mt-5"> Home </a>
                    </div>
                </div>`;
                
            const loaderTemplate = `
                <div class="col-12 d-flex justify-content-center align-items-center"> 
                    <div class="spin-loader" ></div>
                </div>`;

            const init = async () => {
                const response = await axios.get(`/api/pagecategory`);
                const { data } = response.data;

                let categories = data.map(( item , index) => {
                                    return (`
                                        <a class="rounded-pill btn bg-slick-category ${index % 3 == 0 ? 'bg-slick-category-3' : (index % 2 == 0 ? 'bg-slick-category-1' : 'bg-slick-category-2')} badge mx-2 my-2 py-2 category-select ${item.id == currentCategory ? 'active-slick' : ''}" data-id="${item.id}">
                                            <span> ${item.title} </span>
                                        </a><br>`);
                                }).join('');

                $('#category').removeClass('d-none');
                $('#category').html(categories);
                // $('#category')[0].slick.refresh();
                // $('#category').slick('slickAdd', categories);
                // $('.badge').on('click', function() {
                //     $(this).addClass('active-slick').siblings().removeClass('active-slick');
                // });
            }

            const elementCards = (item) => {
                const { cover_image, avatar, user_id: id, name, page_url, bio, follow_info, page_category, page_message } = item;
                const { isFollowing: follow, followings_count, followers_count } = follow_info;
                // <p class="card-text" style="font-size: 14px" >${bio === null ? "" : bio }</p>
                // <p class="text-sm pb-0 mb-0 text-line-2" style="min-height: 2.5rem; max-height: 2.5rem;" title="${page_message}">${page_message}</p>
                
                return(
                    `<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mt-3" >
                        <div class="card shadow-sm shadow-hover-sm border card-creator rounded-small inner-card-dark" data-page="${page_url}" style="z-index: 99;" >
                            <img src="${cover_image}" class="card-banner banner-explore" alt="">
                            <div class="card-body position-relative inner-card-dark rounded-bottom-small">
                                <div class="position-absolute " style="top: -30px;">
                                    <div class="d-flex justify-content-around">
                                        <img src="${avatar}" class="rounded-circle shadow-sm bg-white icon-80" alt="">
                                    </div>
                                </div>
                                <div class="position-absolute" style="top: -30px; right: 10px;">
                                    <button class="btn shadow-sm ${follow === false ? "btn-primary" : "btn-outline-primary"} btn-sm text-sm rounded-pill btn-follow" id="btn-follow-${id}" data-id="${id}" style="margin-left: 60px !important; z-index: 99999; margin-top: 40px !important" > ${follow === false ? "Follow" : "Unfollow"}</button>
                                </div>
                                <h6 class="card-title fw-bold pt-5 pb-0 mb-0 text-line-1" title="${escape(name)}">${escape(name)}</h6>
                                <span class="text-sm text-muted text-line-1 pb-0 mb-2" title="${page_category}">${page_category}</span>
                                <div class="d-flex justify-content-between gap-2">
                                    <span class="fw-semibold text-line-1" title="Following"> <span class="text-primary followings-count-${id}" data-followings="${followings_count}"> ${kNFormatter(followings_count)}</span> Following</span> 
                                    <span class="fw-semibold text-line-1" title="Follower"> <span class="text-primary followers-count-${id}" data-followers="${followers_count}"> ${kNFormatter(followers_count)}</span> Follower</span> 
                                </div>
                            </div>
                        </div>
                    </div>`);
            }

            const fetchCreator = async (id = 0, page = 1) => {
                $("#cards").html(loaderTemplate);
                
                const result = await axios.get(`/api/explore?page=${page}&category_id=${id}&keywords=${search}${user_auth_param}`)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;
                        const pages = result.data.pages;
                        const links = result.pagging.links;

                        $("#links").html(links);
                        if (pages.length) {
                            $("#cards").html(pages.map((item) => elementCards(item)).join(''));
                        } else {
                            $("#cards").html(notFoundTemplate);
                        }
                        
                        return data;
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;
                        
                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });
                        
                        $("#cards").html(errorTemplate);

                        return data;
                    }).finally(() => {

                    });
            }

            const follow = async (id) => {
                const formData = new FormData();
                formData.append('user_id', id);
                
                $(`#btn-follow-${id}`).attr({"disabled": true}).html('Loading...');
                const result = await axios.post(`/api/follow`, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;
                        const { follow = false, info = '' } = result;

                        let counting = 0;
                        let followCountWrapper = $(`.followers-count-${id}`);
                        let followCount = parseInt(followCountWrapper.data('followers'));
                        if (follow) {
                            $(`#btn-follow-${id}`).addClass('btn-outline-primary');
                            $(`#btn-follow-${id}`).removeClass('btn-primary');
                            $(`#btn-follow-${id}`).text('Unfollow');

                            counting = ++followCount;
                        } else {
                            $(`#btn-follow-${id}`).removeClass('btn-outline-primary');
                            $(`#btn-follow-${id}`).addClass('btn-primary');
                            $(`#btn-follow-${id}`).text('Follow');

                            counting = --followCount;
                        }

                        followCountWrapper.html(kNFormatter(counting));
                        followCountWrapper.data('followers', counting);

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
                        $(`#btn-follow-${id}`).attr({"disabled": false}).text($(`#btn-follow-${id}`).text());
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

            $(document).on('click', '.card-creator', function(e) {
                window.location = $(this).attr('data-page');
            });

            $(document).on('click', '.category-select', function(e) {
                $(this).addClass('active-slick').siblings().removeClass('active-slick');
                currentCategory = $(this).attr('data-id'); 
                fetchCreator(currentCategory, 1);
            });

            $(() => {
                /*
                $('.regular').slick({
                    infinite: true,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    variableWidth: true,
                    // autoplay: true,
                    // autoplaySpeed: 1500,
                    responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 1,
                            // centerMode: true,
                            variableWidth: true
                        }
                    }, {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            // centerMode: true,
                            variableWidth: true
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            // centerMode: true,
                            variableWidth: true
                        }
                    }]
                });
                */

                init();
                fetchCreator(0, pageNumber);

                $('body').on('click', '.pagination a', function (e) {
                    e.preventDefault();

                    let page = $(this).attr('href').split('page=')[1] || 1;
                    fetchCreator(currentCategory, page); 
                });
            });

        })(jQuery);

    </script>
@endsection