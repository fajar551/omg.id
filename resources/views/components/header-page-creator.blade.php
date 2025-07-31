<style>
    .tooltip>.tooltip-inner {
        background-color: #6103d0;
        color: white;
    }
    .tooltip.top>.tooltip-arrow {
        border-top: 5px solid blue;
    }
    .page-thumbnail img {
        width: 100px; 
        height: 100px;
        object-fit: cover;
    }
    .card-img-overlay {
        /* background: #28282878; */
        background: rgb(0,0,0);
        background: linear-gradient(0deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.3) 100%);
        border-radius: 10px;
    }
    .social-link {
        border-radius: 8px;
        background-color: #ffffffd4;
    }
    .social-link img:hover {
        transform: scale(1.1);
        transition: 0.8s;
    }
    .btn-creator-follow, .btn-bagi {
        width: 50%;
    }
    .btn-report {
        width: 25%;
    }
    .page-info {
        width: 30%;
    } 
    @media(max-width: 768px) {
        .page-info {
            width: 50%;
        }        
    }
    @media(max-width: 425px) {
        .page-info {
            justify-content: center !important;
            width: 100%;
        }
        .page-thumbnail img {
            width: 80px; 
            height: 80px;
        }
    }

    .btn-outline-primary {
        background-color: white !important; 
        color: var(--color-primary);
    }
</style>

<div class="row">
    <div class="col-12 ">

        <div class="card text-white rounded-small shadow border-0" >
            <div class="d-flex" style="min-height: 280px; max-height: 280px;">
                <img src="{{ $page['cover_image'] ?? asset('template/images/herocreator.png') }}" style="width: 100%; object-fit: cover; border-radius: var(--border-radius-sm);">
                <div class="card-img-overlay d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-start card-page-info w-100">
                        <div class="text-center page-thumbnail me-3">
                            <a href="javascript:void(0);" id="btn-change-icon" data-id="{{ $page['id'] }}">
                                <img src="{{ $page['avatar'] ?? asset('assets/img/default-item.svg')}}" alt="profile-img" class="rounded-circle border border-1 shadow-sm bg-white">
                            </a>
                        </div>
                        <div class="page-info">
                            <h4 class="text-line-1 fw-bold" title="">{{ $page['name'] }}</h4>
                            <p class="mb-0 text-line-1 fw-semibold" title=""><span>@</span>{{ $page['page_url'] }} {{ isset($page['category']['title']) ? "- " .$page['category']['title'] : '' }}</p>
                            <div clasa="fw-semibold text-white font-creator"> 
                                <span class="text-white font-creator">Followers </span>
                                <span class="text-white font-creator followers-count" id="countfollowers" data-followers="{{ $page['follow_detail']['followers_count'] }}"> {{ Utils::kNFormatter($page['follow_detail']['followers_count']) }}</span> 
                                <span class="text-white font-creator">&bullet;</span> 
                                <span class="text-white font-creator following-count" data-following="{{ $page['follow_detail']['followings_count'] }}"> Following {{ Utils::kNFormatter($page['follow_detail']['followings_count']) }} </span> 
                            </div>
                            <hr class="mt-2">
                            <div class="d-flex">
                                @php
                                    $user_id = isset($user['id']) ? $user['id'] : null;
                                @endphp
                                @if ($user_id != $page['user_id'])
                                    <button class="btn shadow {{ $page['follow_detail']['isFollowing'] ? 'btn-outline-primary' : 'btn-primary' }} btn-sm btn-creator btn-creator-follow" id="btn-follow" data-id="{{ $page['user_id'] }}" style="font-size: 10px;">
                                        {{ $page['follow_detail']['isFollowing'] === true ? 'UNFOLLOW' : 'FOLLOW' }}
                                    </button>
                                @endif
                                <button class="btn shadow btn-info btn-sm {{ $user_id != $page['user_id'] ? 'mx-2' : 'me-2' }} btn-creator btn-bagi" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-size: 10px;">
                                    BAGI YUK!
                                </button>
                                <a href="{{ route('report.index') . '?link=' . Request::fullUrl() . '&type=creator' }}@if ($user != null) {{ '&email=' . $user['email'] . '&name=' . $user['name'] }} @endif" class="btn shadow btn-outline-warning btn-sm  px-4 btn-creator btn-report" style="font-size: 10px;" data-toggle="tooltip" data-placement="top" title="Laporkan kreator ini" target="_blank">
                                    <i class="ri-error-warning-line" style="font-size: 15px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 end-0">
                    @if (isset($social_links['facebook']) || isset($social_links['instagram']) || isset($social_links['twitter']) || isset($social_links['youtube']))
                        <div class="badge text-dark d-none d-md-block p-2 me-4 mb-4 social-link">
                            @if (isset($social_links['facebook']))
                                <a href="https://facebook.com/{{ $social_links['facebook'] }}"><img src="{{ asset('template/images/fb.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                            @endif
                            @if (isset($social_links['instagram']))
                                <a href="https://instagram.com/{{ $social_links['instagram'] }}"><img src="{{ asset('template/images/ig.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                            @endif
                            @if (isset($social_links['twitter']))
                                <a href="https://twitter.com/{{ $social_links['twitter'] }}"><img src="{{ asset('template/images/tw.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                            @endif
                            @if (isset($social_links['youtube']))
                                <a href="https://youtube.com/{{ $social_links['youtube'] }}"><img src="{{ asset('template/images/yt.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="hero d-flex position-relative">
            <img src="{{ $page['cover_image'] ?? asset('template/images/herocreator.png') }}" alt=""
                class="img-fluid bg-creator-support" style="border-radius: 8px; height: 225px; width: 100%; ">
            <div class="position-absolute container-profile" style="top: 25%; left: 50px;">
                <div class="d-flex align-items-center">
                    <img src="{{ $page['avatar'] }}" alt="" width="120" class=" img-profile-creator" />
                    <div class="content-profile mx-3">
                        <h6 class="text-white font-creator fw-semibold">
                            {{ $page['name'] }}
                        </h6>
                        <span
                            class="text-white font-creator">{{ isset($page['category']['title']) ? $page['category']['title'] : '' }}</span>
                        <br>
                        <span clasa="fw-semibold text-white font-creator"> <span
                                class="text-white font-creator">Followers </span><span class="text-white font-creator"
                                id="countfollowers">
                                {{ $page['follow_detail']['followers_count'] }}</span> <span
                                class="text-white font-creator">.</span> <span class="text-white font-creator">
                                Following {{ $page['follow_detail']['followings_count'] }} </span> </span>

                        <div class="d-flex">
                            @php
                                $user_id = isset($user['id']) ? $user['id'] : null;
                            @endphp
                            @if ($user_id != $page['user_id'])
                                <button class="btn btn-primary btn-sm  px-4 btn-creator " id="btn-follow" data-id="{{ $page['user_id'] }}"
                                    style="font-size: 10px; {{ $page['follow_detail']['isFollowing'] === true ? 'background-color: white; color: #6103d0; border: 2px solid #6103d0' : '' }}">
                                    {{ $page['follow_detail']['isFollowing'] === true ? 'UNFOLLOW' : 'FOLLOW' }}
                                </button>
                            @endif

                            <button
                                class="btn btn-primary btn-sm  px-4 {{ $user_id != $page['user_id'] ? 'mx-2' : 'me-2' }} btn-creator btn-bagi"
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-size: 10px;">
                                BAGI YUK!
                            </button>


                            <a href="{{ route('report.index') . '?link=' . Request::fullUrl() . '&type=creator' }}@if ($user != null) {{ '&email=' . $user['email'] . '&name=' . $user['name'] }} @endif"
                                class="btn btn-primary btn-sm  px-4 btn-creator " style="font-size: 10px;"
                                data-toggle="tooltip" data-placement="top" title="Report this Creator." target="_blank">
                                <i class="ri-error-warning-line" style="font-size: 15px;"></i>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
            @if (isset($social_links['facebook']) || isset($social_links['instagram']) || isset($social_links['twitter']) || isset($social_links['youtube']))
                <span class="badge text-dark d-none d-lg-block">
                    <div class="d-flex justify-content-center px-3 py-2"
                        style="right: 20px; position: absolute; bottom: 40px; margin-left: 50px; border-radius: 8px;background-color: rgba(255, 255, 255, 0.5);">
                        @if (isset($social_links['facebook']))
                            <a href="https://facebook.com/{{ $social_links['facebook'] }}"><img
                                    src="{{ asset('template/images/fb.png') }}" alt="" width="20" height="20"
                                    class="ms-2 me-2" /></a>
                        @endif
                        @if (isset($social_links['instagram']))
                            <a href="https://instagram.com/{{ $social_links['instagram'] }}"><img
                                    src="{{ asset('template/images/ig.png') }}" alt="" width="20" height="20"
                                    class="ms-2 me-2" /></a>
                        @endif
                        @if (isset($social_links['twitter']))
                            <a href="https://twitter.com/{{ $social_links['twitter'] }}"><img
                                    src="{{ asset('template/images/tw.png') }}" alt="" width="20" height="20"
                                    class="ms-2 me-2" /></a>
                        @endif
                        @if (isset($social_links['youtube']))
                            <a href="https://youtube.com/{{ $social_links['youtube'] }}"><img
                                    src="{{ asset('template/images/yt.png') }}" alt="" width="20" height="20"
                                    class="ms-2 me-2" /></a>
                        @endif
                    </div>
                </span>
            @endif
        </div> --}}

    </div>
</div>
@section('scripts')
    <script>
        const pageName = '{{ $page['page_url'] }}';
    </script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/template/js/bootstrap-input-spinner.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/template/vendor/select2/js/select2.min.js') }}"></script>
    @if (env('APP_ENV') == 'production')
        <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js"
data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
    @else
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
    @endif
    <script type="text/javascript" src="{{ asset('assets/js/support-v1.1.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>

    <script>
        (function ($) {
        "use strict";
            
            const authCheck = "{{ auth()->check() }}";
            
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();

                $(".btn-modal").click(function() {
                    $('#content_id').val($(this).data('id'));
                    $('#inputQty').val($(this).data('qty'));
                    if ($(this).data('id')) {
                        $('#content_price').val($(this).data('qty'));
                    } else {
                        $('#content_price').val(0);
                    }
                    $('input[name="type"]').val(2);
                    $("#staticBackdrop").modal("show");
                    const CartTotal = $('#calctotal');
                    let intItem = $(this).data('qty');
                    const itemcard = $('.card-items').data('price');
                    let totalPriceItems = intItem * itemcard;
                    /*  validTotal(totalPriceItems); */
                    CartTotal.html(Rupiah(totalPriceItems));
                });

                $("#btnemailguest").click(function() {
                    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,9})+$/;
                    var email = $('#emailguest').val();
                    if($('#emailguest').val() === '' || !email.match(mailformat)){
                        $('#invalid-feedback-email').addClass('d-block');

                        return false;
                    }
                    $('input[name="email"]').val($('#emailguest').val());
                    $("#emailguestmodal").modal('toggle');
                    // if ($('input[name="email"]').val() != '' || $('input[name="email"]').val() != null) {
                        $('#btnsub').click();
                    // }
                });
                
                $("#btn-show-emailguest").click(function() {
                    const pgid = $('input[name="payment_method_id"]:checked').val();
                    const from = $('#fromuser').val();
                    const selectorPayment = $('.payment-list');
                    const validatorPayment2 = $('#validator-payment2');
                    if(from === ''){
                        $('#feedback-from').addClass('d-block');
                    }
                    if(pgid === '' || pgid === undefined){
                        validatorPayment2.addClass('d-block');
                    }
                    
                    if(pgid != '' && pgid != undefined && from != ''){
                        $("#emailguestmodal").modal("show");
                    }
                });

                $(".btn-bagi").click(function() {
                    $('input[name="type"]').val(1);
                    $('#content_price').val(0);
                });

                $("#btn-follow").on("click", function() {
                    if (!authCheck) {
                        Toast2.fire({ 
                            icon: 'warning', 
                            title: 'Yuk login untuk mengikuti.' 
                        });
                    } else {
                        follow($(this).attr('data-id'));
                    }
                });
                
                $(document).on("change", ".order-content", function() {
                    if ('{{ Request::segment(3) }}' == 'saved') {
                        location.replace('{{ route('creator.savedcontent', ['page_name'=>$page['page_url']]) }}?order='+$(this).val());
                    } else {
                        location.replace('{{ route('creator.content', ['page_name'=>$page['page_url']]) }}?order='+$(this).val()+'@if (isset($category))&category={{$category}} @endif');
                    }
                    
                });

                $('.modal').on('hidden.bs.modal', function(event) {
                    $(this).removeClass('fv-modal-stack');
                    $('body').data('fv_open_modals', $('body').data('fv_open_modals') - 1);
                });

                $('.modal').on('shown.bs.modal', function(event) {
                    // keep track of the number of open modals
                    if (typeof($('body').data('fv_open_modals')) == 'undefined') {
                        $('body').data('fv_open_modals', 0);
                    }

                    // if the z-index of this modal has been set, ignore.
                    if ($(this).hasClass('fv-modal-stack')) {
                        return;
                    }

                    $(this).addClass('fv-modal-stack');
                    $('body').data('fv_open_modals', $('body').data('fv_open_modals') + 1);
                    $(this).css('z-index', 1040 + (10 * $('body').data('fv_open_modals')));
                    $('.modal-backdrop').not('.fv-modal-stack').css('z-index', 1039 + (10 * $('body').data(
                        'fv_open_modals')));
                    $('.modal-backdrop').not('fv-modal-stack').addClass('fv-modal-stack');

                });
            });

            const follow = async (id) => {
                const formData = new FormData();
                formData.append('user_id', id);
                
                $('#btn-follow').attr({"disabled": true}).html('Loading...');
                const result = await axios.post(`/api/follow`, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;
                        const { follow = false, info = '' } = result;

                        let counting = 0;
                        let followCountWrapper = $(`.followers-count`);
                        let followCount = parseInt(followCountWrapper.data('followers'));
                        if (follow) {
                            $('#btn-follow').addClass('btn-outline-primary');
                            $('#btn-follow').removeClass('btn-primary');
                            $('#btn-follow').text('UNFOLLOW');

                            counting = ++followCount;
                        } else {
                            $('#btn-follow').removeClass('btn-outline-primary');
                            $('#btn-follow').addClass('btn-primary');
                            $('#btn-follow').text('FOLLOW');

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
                        $('#btn-follow').attr({"disabled": false}).text($('#btn-follow').text());
                    });
            }
        })(jQuery);
    </script>
@endsection
