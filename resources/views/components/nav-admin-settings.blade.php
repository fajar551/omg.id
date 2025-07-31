<div class="card">
   <div class="card-body">
      <ul class="nav nav-pills nav-fill" id="pills-tab-1" role="tablist">
         <li class="nav-item">
            <a class="nav-link {{ activeRouteName('admin.setting.profile.index') }}" href="{{ route('admin.setting.profile.index') }}">@lang('page.profile')</a>
         </li>
         <li class="nav-item">
            <a class="nav-link {{ activeRouteName('admin.setting.changepw.index') }}" href="{{ route('admin.setting.changepw.index') }}">@lang('page.change_password')</a>
         </li>
      </ul>
   </div>
</div>