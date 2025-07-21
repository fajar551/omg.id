<div class="d-flex justify-content-between align-items-center">
    <nav class="nav p-0 bg-transparent shadow-0 w-100 d-lg-none d-md-flex d-sm-flex">
        <div class="d-flex justify-content-around align-items-center w-100">
            <a class="nav-link p-2 m-0 w-100 text-center goal {{ activeRouteName('creator.index') }}" href="{{ route('creator.index', ['page_name' => $pageName]) }}">
                @if (activeRouteName('creator.index'))
                <img src="{{ asset('template/images/icon/ic_home_active.png') }}" height="25">
                @else
                <img src="{{ asset('template/images/icon/ic_home_inactive.png') }}" height="25">
                @endif
            </a>
            <a class="nav-link p-2 m-0 w-100 text-center goal {{ activeRouteName('creator.content') }}" href="{{ route('creator.content', ['page_name' => $pageName]) }}">
                @if (activeRouteName('creator.content'))
                <img src="{{ asset('template/images/icon/ic_star_active.png') }}" height="25">
                @else
                <img src="{{ asset('template/images/icon/ic_star_inactive.png') }}" height="25">
                @endif
            </a>
            <a class="nav-link p-2 m-0 w-100 text-center goal {{ activeRouteName('creator.savedcontent') }}" href="{{ route('creator.savedcontent', ['page_name' => $pageName]) }}">
                @if (activeRouteName('creator.savedcontent'))
                <img src="{{ asset('template/images/icon/ic_saved_active.png') }}" height="25">
                @else
                <img src="{{ asset('template/images/icon/ic_saved_inactive.png') }}" height="25">
                @endif
            </a>
        </div>
      </nav>
</div>