{{-- <footer class="iq-footer bg-white">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-6">
            <ul class="list-inline mb-0">
               <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
               <li class="list-inline-item"><a href="#">Terms of Use</a></li>
            </ul>
         </div>
         <div class="col-lg-6 d-flex justify-content-end">
            Copyright {{ date('Y') }}&nbsp;<a href="#"> {{ env('APP_NAME', 'OMG.ID') }}</a>&nbsp;All Rights Reserved.
         </div>
      </div>
   </div>
</footer> --}}
<footer>
   <div class="container-xl">
      <div class="row">
         <div class="col-md-12">
            <div class="card mb-3">
               <div class="card-body d-flex justify-content-between">
                  <div class="header-title">
                     <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="{{ route('pages.termofservice') }}">@lang('page.terms_and_condition')</a></li>
                        <li class="list-inline-item"><a href="{{ route('pages.privacypolice') }}">@lang('page.privacy_police')</a></li>
                     </ul>
                  </div>
                  <div class="card-header-toolbar d-flex align-items-center">
                     <div class="form-check form-switch form-check-inline">
                        @lang('page.copy_right', ['year' => date('Y'), 'app_name' => '<a href="/">' .env('APP_NAME', 'OMG.ID') .'</a>'])
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>
<nav class="iq-float-menu">
   <input type="checkbox" class="iq-float-menu-open" name="menu-open" id="menu-open" />
   <label class="iq-float-menu-open-button" for="menu-open">
      <span class="lines line-1"></span>
      <span class="lines line-2"></span>
      <span class="lines line-3"></span>
   </label>
   <button class="iq-float-menu-item bg-danger"  data-toggle="tooltip" data-placement="top" title="Color Mode" id="dark-mode" data-active="false"><i class="ri-sun-line"></i></button>
   {{-- <button class="iq-float-menu-item bg-info"  data-toggle="tooltip" data-placement="top" title="Direction Mode" data-mode="rtl"><i class="ri-text-direction-r"></i></button> --}}
   {{-- <button class="iq-float-menu-item bg-warning" data-toggle="tooltip" data-placement="top" title="Comming Soon"><i class="ri-palette-line"></i></button>  --}}
</nav>
