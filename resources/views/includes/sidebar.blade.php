<div class="iq-sidebar sidebar-default">
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="{{ activeRouteName('home') }}">
                    <a href="{{ route('home') }}" class=" ">
                        <i class="ri-stack-line"></i>
                        <span> @lang('page.menu_dashboard') </span>
                    </a>
                </li>
                <li class="{{ activeRouteName('page.*') }}">
                    <a href="{{ route('page.index') }}" class=" ">
                        <i class="las la-chalkboard"></i>
                        <span> @lang('page.page') </span>
                    </a>
                </li>
                <li class="{{ activeRouteName('goal.*') }}">
                    <a href="{{ route('goal.mygoal.index') }}" class=" ">
                        <i class="las la-certificate"></i>
                        <span> @lang('page.menu_goal') </span>
                    </a>
                </li>
                <li class="{{ activeRouteName('item.*') }}">
                    <a href="{{ route('item.index') }}" class=" ">
                        <i class="las la-tasks"></i>
                        <span> @lang('page.menu_item') </span>
                    </a>
                </li>
                <li class="{{ activeRouteName('overlay.*') }}">
                    <a href="{{ route('overlay.index') }}" class=" ">
                        <i class="las la-video"></i>
                        <span> @lang('page.menu_overlay') </span>
                    </a>
                </li>
                <li class="{{ activeRouteName('balance.*') }}">
                    <a href="{{ route('balance.index') }}" class=" ">
                        <i class="las la-wallet"></i>
                        <span> @lang('page.menu_balance') </span>
                    </a>
                </li>
                <li class="{{ activeRouteName('integration.*') }} ">
                    <a href="{{ route('integration.discord.index') }}" class=" ">
                        <i class="las la-users"></i>
                        <span> @lang('page.menu_integration') </span>
                    </a>
                </li>
                <li class="{{ activeRouteName('setting.*') }} ">
                    <a href="{{ route('setting.profile.index') }}" class=" ">
                        <i class="las la-tools"></i>
                        <span> @lang('page.menu_setting') </span>
                    </a>
                </li>
                @if (auth()->check() &&
                        auth()->user()->hasRole(['creator']))
                    <li class="{{ activeRouteName('products.*') }}">
                        <a href="{{ route('products.index') }}" class=" ">
                            <i class="las la-box"></i>
                            <span>Produk Saya</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <div class="p-5"></div>
    </div>
</div>
