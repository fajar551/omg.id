<nav class="nav d-flex justify-content-start align-items-center w-100 gap-2 p-2 bg-white shadow mb-3 rounded-small">
   <a class="nav-link goal text-center text-dark {{ activeRouteName('integration.discord.index') }}" href="{{ route('integration.discord.index') }}">@lang('page.discord')</a>
   <a class="nav-link goal text-center text-dark {{ activeRouteName('integration.custom.index') }}" href="{{ route('integration.custom.index') }}">@lang('page.webhook')</a>
</nav>