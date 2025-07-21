<div class="fixed-top">
    <nav class="container navbar-container navbar navbar-expand-lg navbar-light nav-home d-flex align-items-center justify-content-between px-3 shadow rounded-pill rounded-bottom-3-sm mt-md-3 mt-0" id="nav-home" data-aos="fade-down" data-aos-duration="1000">
        <a href="#" class="navbar-toggler burger p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon"></span>
        </a>
        <a class="navbar-brand brand d-md-flex d-none gap-2 ms-auto" href="{{ url('/') }}">
            <img src="{{ asset('template/images/omg.png') }}" alt="" class="img-fluid icon-40">
            <span class="fw-bold d-none d-md-flex  align-items-center"> OMG.ID</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mx-auto">
                @if (activeRouteName('supporter.*'))
                <!-- Nav Supporter Start-->
                <li class="nav-item stepnav1 {{ activeRouteName('supporter.subscribedcontent') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('supporter.subscribedcontent') }}" aria-current="page" href="{{ route('supporter.subscribedcontent') }}">
                        <img src="{{ asset('template/images/icon/ic-karyaof.svg') }}" alt="" class="icon-nav mx-2 my-2 icon-20">
                        <img src="{{ asset('template/images/icon/ic_karya.svg') }}" alt="" class="icon-active mx-2 my-2 icon-20">
                        @lang('page.content')
                    </a>
                </li>
                <li class="nav-item stepnav2 {{ activeRouteName('supporter.supporthistory') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('supporter.supporthistory') }}" aria-current="page" href="{{ route('supporter.supporthistory') }}">
                        <img src="{{ asset('template/images/icon/ic-support-inactive.svg') }}" alt="" class="icon-nav mx-2 my-2 icon-20">
                        <img src="{{ asset('template/images/icon/ic-support-active.svg') }}" alt="" class="icon-active mx-2 my-2 icon-20">
                        @lang('Dukungan')
                    </a>
                </li>
                <li class="nav-item stepnav3 {{ activeRouteName('supporter.followedcreator') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('supporter.followedcreator') }}" aria-current="page" href="{{ route('supporter.followedcreator') }}">
                        <img src="{{ asset('template/images/icon/ic-followers-inactive.svg') }}" alt="" class="icon-nav mx-2 my-2 icon-20">
                        <img src="{{ asset('template/images/icon/ic-followers-active.svg') }}" alt="" class="icon-active mx-2 my-2 icon-20">
                        @lang('Mengikuti')
                    </a>
                </li>
                <!-- Nav Supporter End -->
                @else
                <!-- Nav Creator Start-->
                <li class="nav-item step1 {{ activeRouteName('home') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('home') }}" aria-current="page" href="{{ route('home') }}">
                        <img src="{{ asset('template/images/icon/dasboard.png') }}" alt="" class="icon-active mx-2 my-2 icon-20">
                        <img src="{{ asset('template/images/icon/home.png') }}" alt="" class="icon-nav mx-2 my-2 icon-20">
                        @lang('page.menu_dashboard')
                    </a>
                </li>
                <li class="nav-item mx-3 step2 {{ activeRouteName('goal.*') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('goal.*') }}" aria-current="page" href="{{ route('goal.mygoal.index') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('page.menu_goal')">
                        <img src="{{ asset('template/images/icon/goal-active.png') }}" alt="" class="icon-active my-2 mx-2 icon-20">
                        <img src="{{ asset('template/images/icon/goal.svg') }}" alt="" class="icon-nav my-2 mx-2 icon-20">
                        @lang('page.menu_goal')
                    </a>
                </li>
                <li class="nav-item step3 {{ activeRouteName('item.*') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('item.*') }}" aria-current="page" href="{{ route('item.index') }}">
                        <img src="{{ asset('template/images/icon/item-active.png') }}" alt="" class="icon-active my-2  mx-2 icon-20">
                        <img src="{{ asset('template/images/header/item.svg') }}" alt="" class="icon-nav my-2 mx-2 icon-20">
                        @lang('page.menu_item')
                    </a>
                </li>
                <li class="nav-item mx-3 step4 {{ activeRouteName('overlay.*') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('overlay.*') }}" aria-current="page" href="{{ route('overlay.index') }}">
                        <img src="{{ asset('template/images/icon/ic-overlay.png') }}" alt="" class="icon-active my-2 mx-2 icon-20">
                        <img src="{{ asset('template/images/icon/overlay.svg') }}" alt="" class="icon-nav my-2 mx-2 icon-20">
                        @lang('page.menu_overlay')
                    </a>
                </li>
                <li class="nav-item step5 {{ activeRouteName('balance.*') }} {{ activeRouteName('payoutaccount.*') }} ">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('balance.*') }}{{ activeRouteName('payoutaccount.*') }} " aria-current="page" href="{{ route('balance.index') }}">
                        <img src="{{ asset('template/images/icon/balance-active.png') }}" alt="" class="icon-active my-2  mx-2 icon-20">
                        <img src="{{ asset('template/images/icon/saldo.svg') }}" alt="" class="icon-nav my-2 mx-2 icon-20">
                        @lang('page.menu_balance')
                    </a>
                </li>
                <li class="nav-item mx-3 step6 {{ activeRouteName('integration.*') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('integration.*') }}" aria-current="page" href="{{ route('integration.discord.index') }}">
                        <img src="{{ asset('template/images/icon/link-active.png') }}" alt="" class="icon-active my-2  mx-2 icon-20">
                        <img src="{{ asset('template/images/icon/link.svg') }}" alt="" class="icon-nav my-2 mx-2 icon-20">
                        @lang('page.menu_integration')
                    </a>
                </li>
                @feature('creator_page')
                <li class="nav-item step7 {{ activeRouteName('content.*') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('content.*') }}" aria-current="page" href="{{ route('content.index') }}">
                        <img src="{{ asset('template/images/icon/ic_karya.svg') }}" alt="" class="icon-active my-2  mx-2" width="20" height="20">
                        <img src="{{ asset('template/images/icon/ic-karyaof.svg') }}" alt="" class="icon-nav my-2 mx-2" width="20" height="20">
                        @lang('page.content')
                    </a>
                </li>
                @endfeature
                <li class="nav-item mx-3 step8 {{ activeRouteName('setting.*') }}">
                    <a class="nav-link fw-semibold text-dark d-flex flex-column align-items-center justify-content-center py-1 {{ activeRouteName('setting.*') }}" aria-current="page" href="{{ route('setting.profile.index') }}">
                        <img src="{{ asset('template/images/icon/settings-active.png') }}" alt="" class="icon-active my-2  mx-2" width="20" height="20">
                        <img src="{{ asset('template/images/icon/setting.png') }}" alt="" class="icon-nav my-2 mx-2" width="20" height="20">
                        @lang('page.menu_setting')
                    </a>
                </li>
                <!-- Nav Creator End -->
                @endif
            </ul>
        </div>
        <div class="d-flex align-items-center justify-content-end ms-auto">
            @auth
            <!-- Dropdown Notification -->
            @include('components.navbar-dropdown-notification', ['dropMode' => 'dropdown-menu-md-end dropdown-menu-end'])
                    
            <!-- Dropdown Profile -->
            @include('components.navbar-dropdown-profile', ['dropMode' => 'dropdown-menu-md-end dropdown-menu-end'])
            @endauth

            @guest
            <li class="nav-item my-auto d-flex gap-2">
                <a href="{{ route('register') }}" class="btn btn-md btn-outline-info shadow-sm" type="button">Register</a>
                <a href="{{ route('login') }}" class="btn btn-md btn-primary shadow-sm" type="button">Login</a>
            </li>
            @endguest
        </div>
    </nav>
</div>

@include('components.nav-sidebar')