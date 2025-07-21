@extends('layouts.template-support')

@section('title', __($page['name'] . ' | ' . 'Dukungan'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/vendor/select2/css/select2.min.css') }}">
    <style>
        .pay-invalid .bg-pay {
            border-color: #ff9b8a;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        #btn-mediashare {
            width: 50%;
        }

        #pg-mobile {
            display: none;
        }

        #pg-desktop {
            display: block;
        }

        @media(max-width: 768px) {
            #pg-mobile {
                display: block;
            }

            #pg-desktop {
                display: none;
            }

            #btn-mediashare {
                width: 100%;
            }
        }

        .custom-control-input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .custom-radio-box {
            cursor: pointer;
        }

        .custom-radio-box .custom-radio-box-main-text {
            font-size: 2.25rem;
        }

        .custom-radio-box input[type="radio"]:checked+div {
            background-color: #6103d0;
            color: white;
        }

        .custom-radio-box input[type="radio"]:checked+div:hover {
            background-color: #6103d0;
            color: white;
        }

        .custom-radio-box input[type="radio"]+div {
            transition: all 0.2s ease-in-out;
        }

        .page-thumbnail img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .card-img-overlay {
            background: rgb(0, 0, 0);
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.3) 100%);
            border-radius: 10px;
            min-height: 280px;
            max-height: 280px;
        }

        @media(max-width: 425px) {
            .page-thumbnail img {
                width: 80px;
                height: 80px;
            }
        }

        @media(min-width: 320px) {
            .justify-content-sm-start {
                justify-content: flex-start !important;
            }
        }

        @media(max-width: 320px) {
            .follow-info {
                display: none !important;
            }
        }

        .hero-creator {
            width: 100%;
            object-fit: cover;
            border-top-left-radius: var(--border-radius-sm);
            border-top-right-radius: var(--border-radius-sm);
        }

        .img-pay img {
            width: auto;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }

        .banner-support {
            height: 280px;
            min-height: 280px; 
        }
    </style>
@endsection

@section('content')
    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative pt-3 mt-5">
            <div class="row px-lg-5 px-3">
                <div class="col-12" data-aos="zoom-in-up" data-aos-duration="800">
                    <form action="" autocomplete="off" method="POST" id="formsupport" class="needs-validation" novalidate>
                        <div class="card rounded shadow card-dark">
                            <div class="card-header d-flex banner-support p-0 border-0">
                                <img src="{{ $page['cover_image'] ?? asset('template/images/herocreator.png') }}" class="hero-creator" style="">
                                <div class="row card-img-overlay d-flex align-items-center m-0">
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-12">
                                        <div class="d-flex align-items-start w-100">
                                            <div class="text-center page-thumbnail me-3">
                                                <a href="javascript:void(0);" id="btn-change-icon" data-id="{{ $page['id'] }}">
                                                    <img src="{{ $page['avatar'] ?? asset('assets/img/default-item.svg') }}" alt="profile-img" class="rounded-circle border border-1 shadow-sm bg-white">
                                                </a>
                                            </div>
                                            <div class="text-white">
                                                <h4 class="text-line-1 fw-bold" title="">{{ $page['name'] }}</h4>
                                                <p class="mb-0 text-line-1 fw-semibold" title=""><span>@</span>{{ $page['page_url'] }} {{ isset($page['category']['title']) ? '- ' . $page['category']['title'] : '' }}</p>
                                                <div class="fw-semibold follow-info">
                                                    <span>{{ $page['page_message'] }} </span>
                                                </div>
                                                <hr class="mt-2">
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($creatorGoal))
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card shadow rounded">
                                            <div class="card-body">
                                                @php $textGoal = $creatorGoal['goal']['title'] . ' ' . $creatorGoal['goalProgress']['progress'] . '%'; @endphp
                                                <span class="text-primary text-line-1 fs-6 text-primary-bold" title="{{ $textGoal }}">{{ $textGoal }}</span>
                                                @include('components.goal-progress-sm', ['progress' => $creatorGoal['goalProgress']['progress']])
                                                @if ($creatorGoal['goal']['target_visibility'] == 1)
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-sm text-primary">{{ $creatorGoal['goalProgress']['formated_target_achieved'] }}</span>
                                                        <span class="text-sm text-primary">{{ $creatorGoal['goal']['formated_target'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body row px-md-4 px-3">
                                <div class="col-sm-12 mt-4" id="container-item" data-count="{{ count($item) }}">
                                    <h4 class="fw-bold text-center">@lang('Dukungan')</h4>
                                    @foreach ($item as $items)
                                        @if ($loop->first)
                                            <div class="card card-items rounded border-info" id="item-box-{{ $items['id'] }}" data-id="{{ $items['id'] }}" data-name="{{ $items['name'] }}" data-price="{{ (int) filter_var($items['price'], FILTER_SANITIZE_NUMBER_INT) }}" data-icon="{{ $items['icon'] }}">
                                                <div class="card-body px-md-4 px-2">
                                                    <div class="row">
                                                        <div class="col-sm-2 col-md-2 col-4">
                                                            <div class="d-flex justify-content-center align-self-center h-100">
                                                                <div class="">
                                                                    <img src="{{ $items['icon'] }}" alt="{{ $items['name'] }}" class="img-fluid mx-auto w-100 d-block">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-7 col-md-6 col-6">
                                                            <div class="d-flex h-100 mb-3">
                                                                <div class="justify-content-center align-self-center">
                                                                    <h3 class="py-0 my-0 fw-semibold text-line-2" title="{{ $items['name'] }}">
                                                                        {{ $items['name'] }}
                                                                    </h3>
                                                                    <div class="price text-line-1" title="{{ $items['formated_price'] }}">
                                                                        {{ $items['formated_price'] }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 col-md-4 col-12">
                                                            <div class="d-flex justify-content-center align-items-center h-100 mt-md-0 mt-2">
                                                                <div class="input-quantity number-spinner w-100">
                                                                    <div class="input-group input-group-sm">
                                                                        <button class="btn btn-danger btn-quantity p-0 me-2" type="button" data-dir="dwn" id="button-item-minus">
                                                                            <span class="fw-bold fs-5 m-0 p-0">-</span>
                                                                        </button>
                                                                        <input type="number" id="inputQty" onkeypress="return GeInttOnly(event)" class="form-control text-center mx-1 disabled  rounded-pill" value="1" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                                        <button class="btn btn-primary btn-quantity p-0 ms-2" type="button" data-dir="up" id="button-item-plus">
                                                                            <span class="fw-bold fs-5 m-0 p-0">+</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <div class="form-group">
                                        <label for="fromuser" class="form-label">@lang('form.lbl_from')</label> <span class="text-danger">*</span>
                                        <input type="text" value="{{ @Auth::user()->name ?? '' }}" name="name" class="form-control" id="fromuser" placeholder="Budi Luhur" autocomplete="off">
                                        <div class="invalid-feedback" id="feedback-from">@lang('Nama wajib diisi')</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <div class="form-group">
                                        <label for="useremail" class="form-label">@lang('form.lbl_email')</label> <span class="text-danger">*</span>
                                        <input type="email" value="{{ @Auth::user()->email ?? '' }}" name="email" class="form-control" id="useremail" placeholder="budi@mail.com" autocomplete="off">
                                        <div class="invalid-feedback" id="feedback-email">@lang('Email harus berupa alamat surel yang valid.')</div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <label for="frommassage" class="col-form-label">@lang('form.lbl_support_message')</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" placeholder="Semangat berkarya kak!" id="frommassage"></textarea>
                                    </div>
                                </div>
                                @if (@$mediaShare->status)
                                    <div class="col-sm-12 mt-4 py-3">
                                        <h4 class="fw-bold text-center">@lang('Media Share')</h4>
                                        <div class="form-group text-center">
                                            <button type="button" id="btn-mediashare" class="btn btn-primary mb-1"><i class="fab fa-youtube"></i> Youtube</button>
                                        </div>
                                        <div id="main-mediashare" class="media-share d-none">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="youtubeurl" class=" col-form-label">Youtube Url</label>
                                                        <input type="text" id="youtubeurl" name="media_share[url]" class="form-control" id="media_shareurl" placeholder="https://www.youtube.com/watch?v=ySQivqOeviA" autocomplete="off">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="youtubestart" class=" col-form-label">Mulai detik</label>
                                                        <input type="number" id="youtubestart" name="media_share[startSeconds]" min="1" max="{{ $mediaShare->max_duration }}" class="form-control" id="media_shareurl" placeholder="0" autocomplete="off">
                                                        <div class="invalid-feedback">Starting seconds must be filled</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" id="youtubeurl" name="media_share[url]">
                                    <input type="hidden" id="youtubestart" name="media_share[url]">
                                @endif
                                <div class="col-sm-12 mt-4">
                                    <h4 class="fw-bold text-center">@lang('page.payment_method') <span class="text-danger">*</span></h4>
                                    <div id="pg-desktop">
                                        <div class="row px-5">
                                            <div class="col-12 pt-2 pb-3">
                                                <div id="validator-payment" class="invalid-feedback">@lang('Silahkan pilih metode pembayaran.')</div>
                                            </div>
                                            @foreach ($payment as $pg)
                                                @if ($pg['payment_type'] == 'qris')
                                                    @mobile
                                                        @continue
                                                    @endmobile
                                                @endif
                                                <label class="col-4 mb-2 payment-list custom-radio-box form-group px-4" id="pg-list-{{ $pg['id'] }}" data-id="{{ $pg['id'] }}" data-name="{{ $pg['name'] }}" data-type="{{ $pg['payment_type'] }}" data-bank="{{ $pg['bank_name'] }}" data-description="{{ $pg['image'] }}">
                                                    <input type="radio" id="input-pg-{{ $pg['id'] }}" name="payment_method_id" value="{{ $pg['id'] }}" class="custom-control-input">
                                                    <div class="btn btn-outline-primary bg-pay rounded-pill d-flex p-3 align-items-center justify-content-center w-100 mb-2">
                                                        <div class="img-pay">
                                                            <img src="{{ $pg['image'] }}" alt="" class="">
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div id="pg-mobile">
                                        <div class="col-12 pt-2 pb-3">
                                            <div id="validator-payment2" class="invalid-feedback">Payment Method is required</div>
                                        </div>
                                        <div class="form-group">
                                            <select id="selectPG" class="form-select form-select-lg mb-3" aria-label="Default select example">
                                                <option value="">Choice Payment</option>
                                                @foreach ($payment as $pg)
                                                    @if ($pg['payment_type'] == 'qris')
                                                        @mobile
                                                            @continue
                                                        @endmobile
                                                    @endif
                                                    <option data-img_src="{{ $pg['image'] }}" value="{{ $pg['id'] }}">{{ $pg['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row px-3 py-2 d-flex justify-content-between align-items-center">
                                    <div class="col-8">
                                        <h4 class="fw-bold">Total </h4>
                                        <h4 id="calctotal" class="fw-semibold"></h4>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <div id="tmp"></div>
                                        <input type="hidden" name="is_fullpage" value="1">
                                        <input type="hidden" value="{{ $supporter_id }}" id="supporter_id">
                                        <input type="hidden" name="page_url" value="{{ $page['page_url'] }}">
                                        <input type="hidden" name="type" value="1">
                                        <button type="submit" class="btn btn-primary rounded-pill w-100" id="btn-pay">@lang('form.btn_pay') </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        const pageName = '{{ $page['page_url'] }}';
    </script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/template/js/bootstrap-input-spinner.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/template/vendor/select2/js/select2.min.js') }}"></script>
    @if (env('APP_ENV') == 'production')
        <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ Config::get('midtrans.client_key') }}"></script>
    @else
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ Config::get('midtrans.client_key') }}"></script>
    @endif
    <script type="text/javascript" src="{{ asset('assets/js/support-v1.1.js') }}"></script>
@endsection
