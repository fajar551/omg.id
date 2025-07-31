<div class="col-12 d-lg-none d-sm-block">
    <div class="d-flex justify-content-end dropdown mb-3 ">
        <button class="btn btn-outline-primary d-flex justify-content-between align-items-center dropdown-mobile" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="width: 134px; border-radius: 8px; " >
            @if (activeRouteName('goal.mygoal.*'))
                @lang('page.active')
            @elseif (activeRouteName('goal.history.*'))
                @lang('page.history')
            @endif
            <i class="fas fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end rounded-small border-1 shadow" aria-labelledby="dropdownMenuButton1">
            <li>
                <a class="dropdown-item {{ activeRouteName('goal.history.*') }}" href="{{ route('goal.history.index') }}" style="font-size: 14px !important;" > @lang('page.history')</a>
            </li>
            <li>
                <a class="dropdown-item {{ activeRouteName('goal.mygoal.*') }}" href="{{ route('goal.mygoal.index') }}" style="font-size: 14px !important;">@lang('page.active')</a>
            </li>
        </ul>
    </div>
</div>