<div class="dropdown my-auto step10">
    <a id="navbarDropdownUser" class="nav-link dropdown-toggle p-1" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
        <img src="{{ Auth::user()->profile_picture ? route('api.profile.preview', ['file_name' => auth()->user()->profile_picture]) : asset('template/images/user/user.png') }}" alt="avatar" class="rounded-circle border border-1 border-secondary icon-30">
    </a>
    <ul class="dropdown-menu {{ $dropMode ?? 'dropdown-menu-md-end dropdown-menu-sm-start' }} p-0 border-0 position-absolute" aria-labelledby="navbarDropdownUser">
        <div class="card shadow m-0 show-notification border-0 rounded bg-light">
            <div class="card-header border-0 d-flex justify-content-between bg-transparent rounded-top-small">
                <div class="header-title">
                    <h5 class="mb-1 text-dark"> {{ __('email.greeting_user', ['user' => explode(' ', $name = Auth::user()->name)[0]]) }}</h5>
                    <a href="{{ Auth::user()->page ? route('creator.index', ['page_name' => Auth::user()->page->page_url]) : 'javascript:void(0);' }}" class="btn btn-link p-0 text-primary" target="_blank">
                        <small class=""><span>@</span>{{ Auth::user()->page ? Auth::user()->page->page_url : Auth::user()->username }}</small>
                    </a>
                </div>
                <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" role="switch" id="darkSwitch">
                    <label class="form-check-label ms-1" for="darkSwitch">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-brightness-high ic-dark" viewBox="0 0 16 16">
              <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"></path>
            </svg></label>
                </div>
            </div>
            <div class="card-body card-notification p-0 bg-transparent">
                <div class="bg-white">
                    <a href="{{ route('home') }}">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                            <div class="rounded shortcut-icon">
                                <img src="{{ asset('template/images/icon/dasboard.png') }}" class="w-100" width="">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">Dashboard</h6>
                                <small class="mb-0">Lihat progres dukungan.</small>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('setting.profile.index') }}">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                            <div class="rounded shortcut-icon">
                                <img src="{{ asset('template/images/icon/ic_account.svg') }}" class="w-100" width="">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">Account Setting</h6>
                                <small class="mb-0">Kelola informasi personal.</small>
                            </div>
                        </div>
                    </a>
                    @feature('manage_page')
                    <a href="{{ route('page.index') }}">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                            <div class="rounded shortcut-icon">
                                <img src="{{ asset('template/images/icon/ic_page.svg') }}" class="w-100">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">My Page</h6>
                                <small class="mb-0">Kelola halaman Kreator.</small>
                            </div>
                        </div>
                    </a>
                    @endfeature
                    <a href="{{ Auth::user()->page ? route('support.index', ['page_name' => Auth::user()->page->page_url]) : route('setting.supportpage.index') }}">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                            <div class="rounded shortcut-icon">
                                <img src="{{ asset('template/images/icon/ic_support.svg') }}" class="w-100">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">My Support Page</h6>
                                <small class="mb-0">Lihat halaman dukungan.</small>
                            </div>
                        </div>
                    </a>
                    @feature('supporter_page')
                        @if (activeRouteName('supporter.*'))
                            <a href="{{ route('home') }}">
                                <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                                    <div class="rounded shortcut-icon">
                                        <img src="{{ asset('template/images/icon/ic-people.svg') }}" class="w-100">
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold">Open As Creator</h6>
                                        <small class="mb-0">Buka halaman Kreator.</small>
                                    </div>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('supporter.subscribedcontent') }}">
                                <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                                    <div class="rounded shortcut-icon">
                                        <img src="{{ asset('template/images/icon/ic-people.svg') }}" class="w-100">
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold">Open As Supporter</h6>
                                        <small class="mb-0">Buka halaman Supporter.</small>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endfeature
                    @feature('explore')
                    <a href="{{ route('explore.index') }}">
                      <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                          <div class="rounded shortcut-icon">
                              <img src="{{ asset('template/images/search.png') }}" class="w-100">
                          </div>
                          <div class="ms-3">
                              <h6 class="mb-0 fw-bold">Explore</h6>
                              <small class="mb-0">Cari kreator.</small>
                          </div>
                      </div>
                    </a>
                    @endfeature
                </div>
            </div>
            <div class="card-footer border-0 p-2 text-center bg-white rounded-bottom-small">
                @include('includes.form-logout')
            </div>
        </div>
    </ul>
</div>