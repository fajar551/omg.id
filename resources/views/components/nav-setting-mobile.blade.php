<div class="col-12 d-lg-none d-sm-block">
    <div class="d-flex justify-content-end dropdown mb-3 ">
        <button class="btn btn-outline-primary d-flex justify-content-between align-items-center dropdown-mobile" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="width: 134px; border-radius: 8px;">
            @if (activeRouteName('setting.profile.index'))
                @lang('page.profile')
            @elseif (activeRouteName('setting.supportpage.index'))
                @lang('page.support_page')
            @elseif (activeRouteName('setting.changepw.index'))
                @lang('page.change_password')
            @elseif (activeRouteName('setting.social.index'))
                @lang('page.social_link')
            @elseif (activeRouteName('setting.general.index'))
                @lang('page.general')
            @endif
            <i class="fas fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end rounded-small border-1 shadow" aria-labelledby="dropdownMenuButton1">
            <li>
                <a class="dropdown-item {{ activeRouteName('setting.profile.index') }}" href="{{ route('setting.profile.index') }}" style="font-size: 14px !important;" >@lang('page.profile')</a>
            </li>
            <li>
                <a class="dropdown-item {{ activeRouteName('setting.supportpage.index') }}" href="{{ route('setting.supportpage.index') }}" style="font-size: 14px !important;">@lang('page.support_page')</a>
            </li>
            <li>
                <a class="dropdown-item {{ activeRouteName('setting.changepw.index') }}" href="{{ route('setting.changepw.index') }}" style="font-size: 14px !important;">@lang('page.change_password')</a>
            </li>
            <li>
                <a class="dropdown-item {{ activeRouteName('setting.social.index') }}" href="{{ route('setting.social.index') }}" style="font-size: 14px !important;">@lang('page.social_link')</a>
            </li>
            <li>
                <a class="dropdown-item {{ activeRouteName('setting.general.index') }}" href="{{ route('setting.general.index') }}" style="font-size: 14px !important;">@lang('page.general')</a>
            </li>
        </ul>
    </div>
</div>