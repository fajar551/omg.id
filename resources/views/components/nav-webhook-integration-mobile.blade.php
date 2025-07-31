<div class="col-12 d-lg-none d-sm-block">
    <div class="d-flex justify-content-end dropdown mb-3 ">
        <button class="btn btn-outline-primary d-flex justify-content-between align-items-center dropdown-mobile"  style="width: 134px; border-radius: 8px;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            @if (activeRouteName('integration.discord.index'))
                @lang('page.discord')
            @elseif (activeRouteName('integration.custom.index'))
                @lang('page.webhook')
            @endif
            <i class="fas fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu rounded-small border-0" aria-labelledby="dropdownMenuButton1">
            <li>
                <a class="dropdown-item {{ activeRouteName('integration.discord.index') }}" href="{{ route('integration.discord.index') }}" style="font-size: 14px !important;" >@lang('page.discord')</a>
            </li>
            <li>
                <a class="dropdown-item {{ activeRouteName('integration.custom.index') }}" href="{{ route('integration.custom.index') }}" style="font-size: 14px !important;">@lang('page.webhook')</a>
            </li>
        </ul>
    </div>
</div>