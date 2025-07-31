<div class="fixed-top">
    <nav class="container navbar-container navbar navbar-expand-md navbar-light nav-home d-flex align-items-center justify-content-between px-3 shadow rounded-bottom-3" data-aos="fade-down" data-aos-duration="1000">
        <a class="navbar-brand brand d-flex gap-2" href="{{ url('/') }}">
            <img src="{{ asset('template/images/omg.png') }}" alt="" class="img-fluid icon-40">
            <span class="fw-bold d-none d-md-flex align-items-center"> OMG.ID</span>
        </a>
        <div class="d-flex d-md-none align-items-center justify-content-end">
            @if (!request()->routeIs('explore.index'))
                <div class="me-3">
                    @include('components.form-search')
                </div>
            @endif
            <a href="#" class="btn navbar-toggler burger p-1" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <!-- <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li> -->
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto my-md-0 my-2">
                @if (!request()->routeIs('explore.index'))
                <li class="nav-item d-none d-md-block me-3">
                    @include('components.form-search')
                </li>
                @endif
                @auth
                <li class="nav-item my-auto d-flex">
                    <!-- Dropdown Notification -->
                    @include('components.navbar-dropdown-notification')
                    
                    <!-- Dropdown Profile -->
                    @include('components.navbar-dropdown-profile')
                </li>
                @endauth
                @guest
                <li class="nav-item my-auto d-flex gap-2">
                    <a href="{{ route('register') }}" class="btn btn-md btn-outline-info shadow-sm" type="button">Register</a>
                    <a href="{{ route('login') }}" class="btn btn-md btn-primary shadow-sm" type="button">Login</a>
                </li>
                @endguest
            </ul>
        </div>
    </nav>
</div>
