<nav class="nav d-flex justify-content-start align-items-center w-100 gap-2 p-2 bg-white shadow mb-3 rounded-small step11">
   <a class="nav-link goal text-center text-dark step12 {{ activeRouteName('goal.mygoal.*') }}" href="{{ route('goal.mygoal.index') }}">@lang('page.active')</a>
   <a class="nav-link goal text-center text-dark step13 {{ activeRouteName('goal.history.*') }} mx-3" href="{{ route('goal.history.index') }}">@lang('page.history')</a>
</nav>