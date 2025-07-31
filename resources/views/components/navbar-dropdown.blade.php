@auth
    {{-- @Deprecated, Use components.navbar-dropdown-notification and components.navbar-dropdown-profile instead --}}
    <div class=" profile-header dropdown-profile d-flex align-items-center drop-user"  >
        {{-- <img src="{{ Auth::user()->profile_picture ? route('api.profile.preview', ['file_name' => auth()->user()->profile_picture]) : asset('template/images/user/user.png') }}" class="img-fluid rounded-circle " alt="user" width="30" height="30">
        <span class="mx-2">{{ $name = Auth::user()->name }}</span> --}}
        <!--  -->
        <div class="nav-item dropdown dropdown-notif " id="nav-drop1" >
            @php
                $unreadNotifCount = auth()->user()->unreadNotifications->count();
            @endphp
            <a href="#" class="search-toggle d-flex align-items-center dropdown-toggle pt-3 pb-3 @if($unreadNotifCount > 0) pe-0 @endif" id="notification-drop" data-unread="{{ $unreadNotifCount }}" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <img src="{{ asset('template/images/icon/ic-notification.png') }}" alt="" class="icon-nav mx-2" width="20" height="20">
                {{-- <span class="badge bg-danger mb-3" style="font-size: 10px; @if($unreadNotifCount == 0) display:none; @endif" id="notif-badge"> </span> --}}
                <p class="text-white bg-danger position-absolute top-10 translate-middle text-sm text-center" style="width: 10px; height: 10px; border-radius: 100%; right: 0px;" id="notif-badge"> <span style="font-size: 10px; @if($unreadNotifCount == 0) display:none; @endif">&nbsp;</span> </p>
            </a>
            <div class="sub-drop p-0 dropdown-menu bg-transparent border-0 all-notification" aria-labelledby="nav-drop1">
                <div class="card  border-0 shadow m-0" style="border-radius: 10px !important">
                    <div class="card-header d-flex justify-content-between bg-primary" style="border-radius: 10px 10px  0px 0px !important">
                        <div class="header-title bg-primary" >
                            <h5 class="mb-1  text-white"> Notifications</h5>
                            <a href="javascript:void(0);" class="iq-bg-danger-hover " id="mark-all-read">
                                <span class=" font-size-12" id="mark-all-text">Mark All as Read</span>
                            </a>
                        </div>
                        <small class="badge pt-2 " id="notif-count">{{ $unreadNotifCount }}</small>
                    </div>
                    <div class="card-body p-0" id="div-notify" style="max-height: 500px; overflow-y:scroll;"></div>
                    <div class="card-footer p-2" id="div-notify-footer"></div>
                </div>
            </div>
        </div>
        <div class="nav-item dropdown ms-2" id="nav-drop2">
            <a href="#" class="d-flex align-items-center dropdown-toggle " id="drop-down-arrow" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ Auth::user()->profile_picture ? route('api.profile.preview', ['file_name' => auth()->user()->profile_picture]) : asset('template/images/user/user.png') }}" class="rounded-circle" alt="user" width="25" height="25">
                <div class="caption ms-1">
                    <h6 class="mb-0 line-height auth-name" style="">{{ explode(' ', $name = Auth::user()->name)[0] }}</h6>
                </div>
            </a>
            <div class="sub-drop dropdown-menu profile-dropdown caption-menu border-0 p-0" aria-labelledby="nav-drop2">
                <div class="card shadow-none m-0"  style="border-radius: 10px !important">
                    <div class="card-header  bg-primary" style="border-radius: 10px 10px 0px 0px !important">
                        <div class="header-title">
                            <h5 class="mb-0 text-white">{{ __('email.greeting_user', ["user" => $name]) }}</h5>
                            <span class="text-white font-size-12">&nbsp;</span>
                        </div>
                    </div>
                    <div class="card-body p-0 ">
                        <a href="{{ route('setting.profile.index') }}" class="card dop-bg border-0 rounded-0 p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded card-icon bg-soft-info">
                                    <img src="{{ asset('template/images/icon/ic_account.svg') }}" alt="" >
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 ">Account Setting</h6>
                                    <p class="mb-0 font-size-12">Kelola informasi personal.</p>
                                </div>
                            </div>
                        </a>
                        @feature('manage_page')
                        <a href="{{ route('page.index') }}" class="card dop-bg border-0 rounded-0 p-3 ">
                            <div class="d-flex align-items-center">
                                <div class="rounded card-icon bg-soft-primary">
                                    <img src="{{ asset('template/images/icon/ic_page.svg') }}" alt="" >
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 ">My Page</h6>
                                    <p class="mb-0 font-size-12">Kelola halaman kreator.</p>
                                </div>
                            </div>
                        </a>
                        @endfeature
                        <a href="{{ Auth::user()->page ? route('support.index', ['page_name' => Auth::user()->page->page_url]) : route('setting.supportpage.index') }}" target="_blank" class="card dop-bg border-0 rounded-0 p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded card-icon bg-soft-primary">
                                    <img src="{{ asset('template/images/icon/ic_support.svg') }}" alt="" >
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 ">My Support Page</h6>
                                    <p class="mb-0 font-size-12">Lihat halaman dukungan.</p>
                                </div>
                            </div>
                        </a>
                        @feature('supporter_page')
                        @if (activeRouteName('supporter.*'))
                        <a href="{{ route('home') }}" class="card dop-bg border-0 rounded-0 p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded card-icon bg-soft-primary">
                                    <img src="{{ asset('template/images/icon/ic-people.svg') }}" alt="" >
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 ">Open As Creator</h6>
                                    <p class="mb-0 font-size-12">Buka halaman kreator</p>
                                </div>
                            </div>
                        </a>
                        @else
                        <a href="{{ route('supporter.subscribedcontent') }}" class="card dop-bg border-0 rounded-0 p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded card-icon bg-soft-primary">
                                    <img src="{{ asset('template/images/icon/ic-people.svg') }}" alt="" >
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 ">Open As Supporter</h6>
                                    <p class="mb-0 font-size-12">Buka halaman supporter</p>
                                </div>
                            </div>
                        </a>
                        @endif
                        @endfeature
                        @feature('explore')
                        <a href="{{ route('explore.index') }}" class="card dop-bg border-0 rounded-0 p-3 ">
                            <div class="d-flex align-items-center">
                                <div class="rounded card-icon bg-soft-primary">
                                    <img src="{{ asset('template/images/search.png') }}" alt="" style="width: 20px;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 ">Explore</h6>
                                    <p class="mb-0 font-size-12">Cari kreator.</p>
                                </div>
                            </div>
                        </a>
                        @endfeature
                        <div class="d-inline-block  w-100 text-center p-3">
                            <button class="btn btn-primary iq-sign-btn" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}
                                <i class="ri-login-box-line ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
@else
    <div class="d-flex align-items-center gap-1">
        <a href="{{ url('/register') }}" class="btn btn-primary mx-2 d-none d-md-block" style="background-color: transparent !important; color: #6103D0; hh">Daftar</a>
        <a href="{{ url('/login') }}" class="btn btn-primary me-1">Masuk</a>
    </div>
@endauth