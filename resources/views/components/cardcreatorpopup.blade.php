<div class="modal fade pb-4" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" autocomplete="off" method="POST" id="formsupport" class="needs-validation" novalidate>
            <div class="modal-content rounded-small border-0">
                <div class="modal-header bg-modal-header flex-column position-relative">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ $page['avatar'] }}" alt="" class="rounded-circle icon-100" />
                        <div class="content-profile mx-3" style="text-align: start !important">
                            <h6 class="text-white font-creator fw-semibold">
                                {{ $page['name'] }}
                            </h6>

                            <span clasa="fw-semibold text-white "> <span class="text-white font-creator">Folwers
                                    {{ $page['follow_detail']['followers_count'] }}</span> <span class="text-white font-creator">.</span> <span class="text-white font-creator">
                                    Following {{ $page['follow_detail']['followings_count'] }} </span> </span>

                        </div>
                    </div>

                    @if (!empty($creatorGoal))
                        <div class="col-12 my-3">
                            <div class="card rounded-small shadow">
                                <div class="card-body ">
                                    <div class=" px-4 py-3">
                                        <span class="text-primary" style="font-size: 18px; font-weight: bold;">{{ $creatorGoal['goal']['title'] . ' ' . $creatorGoal['goalProgress']['progress'] . '%' }}</span>
                                        @include('components.goal-progress-sm', [
                                            'progress' => $creatorGoal['goalProgress']['progress'],
                                        ])
                                        @if ($creatorGoal['goal']['target_visibility'] == 1)
                                            <div class="d-flex justify-content-between">
                                                <span class="text-sm text-primary">{{ $creatorGoal['goalProgress']['formated_target_achieved'] }}</span>
                                                <span class="text-sm text-primary">{{ $creatorGoal['goal']['formated_target'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="pb-4 position-absolute" style="right: 0">
                        <button type="button" class="btn btn-transparent btn-sm border-0 btn-closes bg-transparent me-2" data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{ asset('template/images/ic_close.svg') }}" alt="" />
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="creatornotif"></div>
                    <div id="" data-count="{{ count($item) }}">
                        @foreach ($item as $items)
                            @if ($loop->first)
                                <div class="card-items" id="item-box-{{ $items['id'] }}" data-id="{{ $items['id'] }}" data-name="{{ $items['name'] }}" data-price="{{ (int) filter_var($items['price'], FILTER_SANITIZE_NUMBER_INT) }}" data-icon="{{ $items['icon'] }}">
                                    <div class="card-body px-5 col-creatoreen text-center">
                                        <img src="{{ $items['icon'] }}" alt="" width="100" class="me-3" />
                                        <div class="body-title ">
                                            <h4 class="text-center fw-bold">
                                                {{ $items['name'] }}
                                            </h4>
                                            <div class="price">
                                                Rp{{ number_format($items['price'], 0, ',', '.') }}
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="col-6">
                                                    <div class="d-flex justify-content-center align-self-center h-100 spinner-item">
                                                        <div class="justify-content-center align-self-center">
                                                            <div class="item">
                                                                <div class="input-quantity number-spinner w-100">
                                                                    <div class="input-group input-group-sm">
                                                                        <button class="btn btn-danger btn-quantity p-0 me-2" type="button" data-dir="dwn" id="button-item-minus">
                                                                            <h5>-</h5>
                                                                        </button>
                                                                        <input type="text" id="inputQty" onkeypress="return GeInttOnly(event)" class="form-control text-center mx-1 disabled  rounded-pill" value="1" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                                        <button class="btn btn-primary btn-quantity p-0 ms-2" type="button" data-dir="up" id="button-item-plus">
                                                                            <h5>+</h5>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
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

                    <div class="">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fromuser" class=" col-form-label">@lang('form.lbl_from')</label> <span class="text-danger">*</span>
                                    <input type="text" value="{{ @Auth::user()->name ?? '' }}" name="name" value="" class="form-control" id="fromuser" placeholder="Budi Luhur" autocomplete="off">
                                    <div class="invalid-feedback" id="feedback-from">@lang('Nama wajib diisi')</div>
                                </div>
                            </div>

                            <div class="col-sm-12" hidden>
                                <div class="form-group">
                                    <label for="useremail" class="col-form-label">@lang('form.lbl_email')</label>
                                    <input type="email" value="{{ @Auth::user()->email ?? '' }}" name="email" class="form-control" id="useremail" placeholder="budi@mail.com" autocomplete="off">
                                    <div class="invalid-feedback">@lang('Email harus berupa alamat surel yang valid.')</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="frommassage" class="col-form-label">@lang('form.lbl_support_message')</label>
                            <div class="col-sm-12">
                                <textarea class="form-control " placeholder="Semangat berkarya kak!" id="frommassage"></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="youtubeurl" name="media_share[url]">
                        <input type="hidden" id="youtubestart" name="media_share[url]">
                        <div id="pg-desktop" style="display: none;">
                            <div class="row px-5 col-creator ">
                                <div class="col-12 pt-2 pb-3">
                                    <h5 class="fw-bold m">@lang('page.payment_method')</h5>
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
                                        <div class="btn bg-pay  rounded-pill btn-outline-primary btns d-flex p-3 align-items-center  justify-content-center shadow">
                                            <div class="img-pay">
                                                <img src="{{ $pg['image'] }}" alt="" class="">
                                            </div>
                                            {{-- <span class="mx-1 text-payement fw-bold">{{ $pg['name'] }}</span> --}}
                                        </div>
                                    </label>
                                @endforeach

                            </div>
                            <hr class="mt-5 mb-3 px-5 col-creator">
                        </div>
                        <div id="pg-mobile" style="display: block;">
                            <label for="useremail" class="col-form-label">@lang('page.payment_method')</label> <span class="text-danger">*</span>
                            <div id="validator-payment2" class="invalid-feedback">Payment Method is required</div>
                            <div class="row" style="padding: 12px;">
                                <select id="selectPG" class="form-select form-select-lg mb-3" aria-label="Default select example" style="font-size: inherit;">
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
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h5 class="text-primary fw-semibold">Total</h5>
                            <h3 class="text-primary fw-semibold" id="calctotal"></h3>
                        </div>

                        <div class="mt-3">
                            <div id="tmp"></div>
                            <input type="hidden" value="{{ $supporter_id }}" id="supporter_id">
                            <input type="hidden" name="page_url" value="{{ $page['page_url'] }}">
                            <input type="hidden" name="type">
                            <input type="hidden" name="content_id" id="content_id">
                            <input type="hidden" name="content_price" id="content_price">
                            @if (isset($user['id']))
                                <button type="submit" class="btn  btn-primary rounded-pill w-100" id="btn-pay">@lang('form.btn_pay')
                                </button>
                            @else
                                <button type="submit" id="btnsub" hidden></button>
                                <button type="button" class="btn  btn-primary rounded-pill w-100" id="btn-show-emailguest">
                                    @lang('form.btn_pay')
                                </button>
                            @endif

                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>
@if (!isset($user['id']))
    <div class="modal fade pb-4" id="emailguestmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="emailguestmodalLabel" aria-hidden="true" style="z-index: 99999">
        <div class="modal-dialog rounded-0">
            <div class="modal-content">
                <div class="modal-header bg-modal-header flex-column position-relative" style="padding: 30px; text-align: center;">
                    {{-- <div class="d-flex align-items-center justify-content-center"> --}}
                    <h4 class="text-white font-creator fw-semibold">
                        @lang('page.supporting_data')
                    </h4>
                    <p class="text-white">@lang('page.supporting_data_desc')</p>
                    {{-- </div> --}}
                    <div class="pb-4 position-absolute" style="right: 0">
                        <button type="button" class="btn btn-transparent btn-sm border-0 btn-closes bg-transparent me-2 " data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{ asset('template/images/ic_close.svg') }}" alt="" />
                        </button>
                    </div>
                </div>
                <div class="modal-body">

                    @if (Route::has('auth.social.provider'))
                        <ul class="nav-link d-grid gap-3 px-md-4 px-0">
                            @feature('auth_facebook')
                            <li class="nav-item social-signin text-center">
                                <a href="{{ url('/auth/facebook') }}" class="btn btn-outline-info rounded-pill w-100 "> 
                                    <i class="fab fa-facebook fs-4 align-middle"></i>
                                    <span class="ms-1">Masuk dengan facebook</span> 
                                </a>
                            </li>
                            @endfeature
                            @feature('auth_twitter')
                            <li class="nav-item social-signin text-center">
                                <a href="{{ url('/auth/twitter') }}" class="btn btn-outline-info rounded-pill w-100">
                                    <i class="fab fa-twitter fs-4 align-middle"></i>
                                    <span class="ms-1"> Masuk dengan twitter</span>
                                </a>
                            </li>
                            @endfeature
                            @feature('auth_google')
                            <li class="nav-item social-signin text-center">
                                <a href="{{ url('/auth/google') }}" class="btn btn-outline-info rounded-pill w-100">
                                    <i class="fab fa-google fs-4 align-middle"></i>
                                    <span class="ms-1">Masuk dengan google</span>
                                </a>
                            </li>
                            @endfeature
                        </ul>

                        <div style="border-bottom:1px solid gray;line-height:16px;text-align:center; opacity:0.5;">
                            <span class="bg-white" style="position:relative;bottom:-8px; padding:0 15px;">@lang('page.guest_email')</span>
                        </div>
                    @endif
                    <div class="form-group mx-3 mt-4 mb-3">
                        <label for="useremail" class="col-form-label">@lang('Guest Email')</label>
                        <input type="email" id="emailguest" name="emailguest" class="form-control border rounded-pill" id="useremail" placeholder="budi@mail.com" autocomplete="off">
                        <div class="invalid-feedback" id="invalid-feedback-email">@lang('Email harus berupa alamat surel yang valid.')</div>
                    </div>
                    <p class="mx-3 text-center">@lang('page.guest_email_desc')</p>
                    <button type="button" id="btnemailguest" class="btn  btn-primary rounded-pill w-100 mt-4">@lang('Lanjut')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
