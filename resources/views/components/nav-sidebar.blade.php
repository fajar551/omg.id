<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold text-primary" id="offcanvasExampleLabel">OMG.ID</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="navbar-nav">
            <ul class="col list-group d-lg-none rounded-0 bg-white p-0"
                style="height: 100vh; position: relative; overflow: auto;">
                @if (activeRouteName('supporter.*'))
                    <!-- Nav Supporter Start-->
                    <li class="list-group-item border-0  py-0 my-1 {{ activeRouteName('supporter.subscribedcontent') }}"
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('supporter.subscribedcontent') }}"
                            aria-current="page" href="{{ route('supporter.subscribedcontent') }}">
                            <img src="{{ asset('template/images/icon/ic_karya.svg') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/ic-karyaof.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            @lang('page.content')
                        </a>
                    </li>
                    <li class="list-group-item border-0  py-0 my-1 {{ activeRouteName('supporter.supporthistory') }}"
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('supporter.supporthistory') }}"
                            aria-current="page" href="{{ route('supporter.supporthistory') }}">
                            <img src="{{ asset('template/images/icon/ic-support-active.svg') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/ic-support-inactive.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            @lang('Dukungan diberikan')
                        </a>
                    </li>
                    <li class="list-group-item border-0  py-0 my-1 {{ activeRouteName('supporter.followedcreator') }}"
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('supporter.followedcreator') }}"
                            aria-current="page" href="{{ route('supporter.followedcreator') }}">
                            <img src="{{ asset('template/images/icon/ic-followers-active.svg') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/ic-followers-inactive.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            @lang('Kreator diikuti')
                        </a>
                    </li>
                    <!-- Nav Supporter End -->
                @else
                    <!-- Nav Creator Start-->
                    <li class="list-group-item border-0  py-0 my-1 {{ activeRouteName('home') }}" style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('home') }}"
                            aria-current="page" href="{{ route('home') }}">
                            <img src="{{ asset('template/images/icon/home.png') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/dasboard.png') }}" alt=""
                                class="icon-active mx-2 icon-20">
                            @lang('page.menu_dashboard')
                        </a>
                    </li>
                    <li class="list-group-item border-0 py-0 my-1 {{ activeRouteName('goal.*') }}" style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('goal.*') }}"
                            aria-current="page" href="{{ route('goal.mygoal.index') }}">
                            <img src="{{ asset('template/images/icon/goal-active.png') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/goal.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            @lang('page.menu_goal')
                        </a>
                    </li>
                    <li class="list-group-item border-0  py-0 my-1 {{ activeRouteName('item.*') }}"
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('item.*') }}"
                            aria-current="page" href="{{ route('item.index') }}">
                            <img src="{{ asset('template/images/icon/item-active.png') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            <img src="{{ asset('template/images/header/item.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            @lang('page.menu_item')
                        </a>
                    </li>
                    <li class="list-group-item border-0 py-0 my-1 {{ activeRouteName('overlay.*') }}"
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('overlay.*') }}"
                            aria-current="page" href="{{ route('overlay.index') }}">
                            <img src="{{ asset('template/images/icon/ic-overlay.png') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/overlay.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            @lang('page.menu_overlay')
                        </a>
                    </li>
                    <li class="list-group-item border-0 py-0 my-1 {{ activeRouteName('balance.*') }} "
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start  {{ activeRouteName('balance.*') }}{{ activeRouteName('payoutaccount.*') }} "
                            aria-current="page" href="{{ route('balance.index') }}">
                            <img src="{{ asset('template/images/icon/saldo.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/balance-active.png') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            @lang('page.menu_balance')
                        </a>
                    </li>
                    <li class="list-group-item border-0 py-0 my-1 {{ activeRouteName('integration.*') }}"
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start  {{ activeRouteName('integration.*') }}"
                            aria-current="page" href="{{ route('integration.discord.index') }}">
                            <img src="{{ asset('template/images/icon/link.svg') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/link-active.png') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            @lang('page.menu_integration')
                        </a>
                    </li>
                    @feature('creator_page')
                        <li class="list-group-item border-0 py-0 my-1 {{ activeRouteName('content.*') }}"
                            style="width: 80%;">
                            <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('content.*') }}"
                                aria-current="page" href="{{ route('content.index') }}">
                                <img src="{{ asset('template/images/icon/ic-karyaof.svg') }}" alt=""
                                    class="icon-nav mx-2 icon-20">
                                <img src="{{ asset('template/images/icon/ic_karya.svg') }}" alt=""
                                    class="icon-active  mx-2 icon-20">
                                @lang('page.content')
                            </a>
                        </li>
                    @endfeature
                    <li class="list-group-item border-0 py-0 my-1 {{ activeRouteName('setting.*') }}"
                        style="width: 80%;">
                        <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('setting.*') }}"
                            aria-current="page" href="{{ route('setting.profile.index') }}">
                            <img src="{{ asset('template/images/icon/setting.png') }}" alt=""
                                class="icon-nav mx-2 icon-20">
                            <img src="{{ asset('template/images/icon/settings-active.png') }}" alt=""
                                class="icon-active  mx-2 icon-20">
                            @lang('page.menu_setting')
                        </a>
                    </li>
                    @if (auth()->check() &&
                            auth()->user()->hasRole(['creator']))
                        <li class="list-group-item border-0 py-0 my-1 {{ activeRouteName('products.*') }}"
                            style="width: 80%;">
                            <a class="nav-link d-flex align-items-center justify-content-start {{ activeRouteName('products.*') }}"
                                aria-current="page" href="{{ route('products.index') }}">
                                <img src="{{ asset('template/images/icon/ic-product.svg') }}" alt=""
                                    class="icon-nav mx-2 icon-20">
                                <img src="{{ asset('template/images/icon/ic-product-active.svg') }}" alt=""
                                    class="icon-active mx-2 icon-20">
                                Produk Saya
                            </a>
                        </li>
                    @endif
                    <!-- Nav Creator End -->
                @endif

                <li class="border-0 mt-5 pt-5 py-5">
                    <div class="card shadow mx-4 mb-2 border-primary bg-info rounded-small">
                        <div class="card-body">
                            <a class="text-primary" href="{{ route('pages.termofservice') }}">
                                @lang('page.privacy_police')
                            </a>
                            <span class="fs-4">&bullet;</span>
                            <a class="text-primary" href=" {{ route('pages.privacypolice') }}">
                                @lang('page.terms_and_condition')
                            </a>
                            <div class="mt-5 d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <a class=" text-primary"><span class="text-dark">&copy;Copyright</span>
                                        <strong>{{ env('APP_NAME', 'OMG.ID Dev ') }}</strong> </a>
                                </div>
                                <img src="{{ asset('template/images/omg.png') }}" alt="" class="-nav"
                                    width="40" height="40">
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
