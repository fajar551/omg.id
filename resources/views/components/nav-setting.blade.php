<nav class="nav d-flex justify-content-around align-items-center w-100 p-2 bg-white shadow rounded-small">
   <a class="nav-link goal text-center text-dark {{ activeRouteName('setting.profile.index') }}" href="{{ route('setting.profile.index') }}">@lang('page.profile')</a>
   <a class="nav-link goal text-center text-dark {{ activeRouteName('setting.supportpage.index') }}" href="{{ route('setting.supportpage.index') }}">@lang('page.support_page')</a>
   <a class="nav-link goal text-center text-dark {{ activeRouteName('setting.changepw.index') }}" href="{{ route('setting.changepw.index') }}">@lang('page.change_password')</a>
   <a class="nav-link goal text-center text-dark {{ activeRouteName('setting.social.index') }}" href="{{ route('setting.social.index') }}">@lang('page.social_link')</a>
   <a class="nav-link goal text-center text-dark {{ activeRouteName('setting.general.index') }}" href="{{ route('setting.general.index') }}">@lang('page.general')</a>
</nav>