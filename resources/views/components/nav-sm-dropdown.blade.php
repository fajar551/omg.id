<style>
    .nav-link.navs {
        color: white !important;
    }

    .btn-secondary:focus {
        box-shadow: none !important;
    }
    .btn-dropdown-sm.active {
        background-color: fixed;
        background: #F3E9FF;
    }
</style>

<div class="navbar-nav sm">
    <ul class="col list-group  navs d-lg-none rounded-0 bg-white p-0" style="height: 100vh; width: 90%; !important; position: relative; overflow: auto; ">

       <li class="list-group-item border-0  py-2 d-flex justify-content-between align-items-center "  >
            <div class="text-primary fw-bold">OMG.ID</div>
            <button class="btn  btn-lg rounded-circle" onclick="myFuncClose()" style=" border: 0 !important; padding: 0; text-decoration: none;">
                <i class="ri-close-fill text-primary" style="color: #6103d0; font-size: 30px; font-weight: 700;"></i>
            </button>

        </li> 
        <!--  <li class="list-group-item border-0  py-0 mb-0 {{ activeRouteName('home') }} mt-4  mr-3" style="width: 80%;" >
            <a class="nav-link d-flex align-items-center justify-content-start text-white  fw-bold t py-0 mb-0 {{ activeRouteName('home') }}" aria-current="page" href="{{ route('home') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/home.png') }}" alt="" class="icon-nav mx-2" width="10" height="10">
                <img src="{{ asset('template/images/icon/dasboard.png') }}" alt="" class="icon-active mx-2" width="18" height="18">
                @lang('page.menu_dashboard')
            </a>
        </li>
        <li class="list-group-item border-0 py-0 mb-0 {{ activeRouteName('goal.*') }}" style="width: 80%;" >
            <a class="nav-link text-center d-flex  align-items-center justify-content-start py-0 mb-0 {{ activeRouteName('goal.*') }}" aria-current="page" href="{{ route('goal.mygoal.index') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/goal-active.png') }}" alt="" class="icon-active  mx-2" width="18" height="18">
                <img src="{{ asset('template/images/icon/goal.svg') }}" alt="" class="icon-nav mx-2" width="18" height="18">
                @lang('page.menu_goal')
            </a>
        </li>
        <li class="list-group-item border-0  py-0 mb-0 {{ activeRouteName('item.*') }}" style="width: 80%;" >

            <a class="nav-link text-center d-flex flex-column align-items-center justify-content-start py-0 mb-0 {{ activeRouteName('item.*') }}" aria-current="page" href="{{ route('item.index') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/item-active.png') }}" alt="" class="icon-active  mx-2" width="18" height="18">
                <img src="{{ asset('template/images/header/item.svg') }}" alt="" class="icon-nav mx-2" width="18" height="18">
                @lang('page.menu_item')
            </a>
        </li>
        <li class="list-group-item border-0 py-0 mb-0 {{ activeRouteName('overlay.*') }}" style="width: 80%;" >
            <a class="nav-link d-flex flex-column align-items-center justify-content-start text-center py-0 mb-0 {{ activeRouteName('overlay.*') }}" aria-current="page" href="{{ route('overlay.index') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/ic-overlay.png') }}" alt="" class="icon-active  mx-2" width="18" height="18">
                <img src="{{ asset('template/images/icon/overlay.svg') }}" alt="" class="icon-nav mx-2" width="18" height="18">
                @lang('page.menu_overlay')
            </a>
        </li> -->
        <li class="nav-item dropdown my-0 {{ activeRouteName('home') }}">
          <a class="nav-link dropdown-toggle  btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('home') }}" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          @lang('page.menu_dashboard')
          </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0"  href="{{ route('home') }}">@lang('page.menu_dashboard')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown  {{ activeRouteName('goal.*') }}"  >
          <a class="nav-link dropdown-toggle d-flex justify-content-between btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('goal.*') }}" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -10px !important " >
             @lang('page.menu_goal')
             <img src="{{ asset('template/images/akar.svg') }}" alt="" class=" my-2  mx-2" width="20" height="20">
          </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0"  href="{{ route('goal.mygoal.index') }}"> @lang('page.menu_goal')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown  {{ activeRouteName('item.*') }}"  >
          <a class="nav-link dropdown-toggle d-flex justify-content-between btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('item.*') }}" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -10px !important " >
               @lang('page.menu_item')
               <img src="{{ asset('template/images/akar.svg') }}" alt="" class=" my-2  mx-2" width="20" height="20">
          </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0 {{ activeRouteName('item.*') }}"  href="{{ route('item.index') }}">  @lang('page.menu_item')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown  {{ activeRouteName('overlay.*') }}"  >
          <a class="nav-link dropdown-toggle d-flex justify-content-between  btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('overlay.*') }}" href="{{ route('overlay.index') }}" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -10px !important " >
             @lang('page.menu_overlay')
             <img src="{{ asset('template/images/akar.svg') }}" alt="" class=" my-2  mx-2" width="20" height="20">
          </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0 {{ activeRouteName('overlay.*') }}" href="{{ route('overlay.index') }}"> @lang('page.menu_goal')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown  {{ activeRouteName('balance.*') }}"  >
          <a class="nav-link dropdown-toggle d-flex justify-content-between  btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('balance.*') }}"  id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -10px !important " >
               @lang('page.menu_balance')
               <img src="{{ asset('template/images/akar.svg') }}" alt="" class=" my-2  mx-2" width="20" height="20">
            </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0"   href="{{ route('balance.index') }}">@lang('page.menu_balance')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown  {{ activeRouteName('integration.*') }}}"  >
          <a class="nav-link dropdown-toggle  d-flex justify-content-between  btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('integration.*') }}" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -10px !important " >
                @lang('page.menu_integration')
                <img src="{{ asset('template/images/akar.svg') }}" alt="" class=" my-2  mx-2" width="20" height="20">
              </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0"  href="{{ route('integration.discord.index') }}">  @lang('page.menu_integration')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown  {{ activeRouteName('content.*') }}"  >
          <a class="nav-link dropdown-toggle  btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('content.*') }}" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -10px !important " >
              @lang('page.content')
              <img src="{{ asset('template/images/akar.svg') }}" alt="" class=" my-2  mx-2" width="20" height="20">
          </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0 "  href="{{ route('content.index') }}"> @lang('page.content')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown  {{ activeRouteName('setting.*') }}"  >
          <a class="nav-link dropdown-toggle d-flex justify-content-between  btn-dropdown-sm py-4 px-3 mb-0 {{ activeRouteName('setting.*') }}" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -10px !important " >
             @lang('page.menu_setting')
             <img src="{{ asset('template/images/akar.svg') }}" alt="" class=" my-2  mx-2" width="20" height="20">
          </a>
          <ul class="dropdown-menu border-0" aria-labelledby="navbarDarkDropdownMenuLink" style="margin-top: -25px !important" >
            <li><a class="dropdown-item nv-sm py-3 my-0 "  href="{{ route('content.index') }}"> @lang('page.menu_setting')</a></li>
            <li><a class="dropdown-item py-3" href="#">Another action</a></li>
            <li><a class="dropdown-item py-3" href="#">Something else here</a></li>
          </ul>
        </li>

       
        <!-- <li class="list-group-item border-0 py-0 mb-0 {{ activeRouteName('balance.*') }} " style="width: 80%;" >
            <a class="nav-link  d-flex flex-column align-items-center justify-content-start  {{ activeRouteName('balance.*') }}{{ activeRouteName('payoutaccount.*') }} " aria-current="page" href="{{ route('balance.index') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/saldo.svg') }}" alt="" class="icon-nav mx-2" width="18" height="18">
                <img src="{{ asset('template/images/icon/balance-active.png') }}" alt="" class="icon-active  mx-2" width="18" height="18">
                @lang('page.menu_balance')
            </a>
        </li>
        <li class="list-group-item border-0 py-0 mb-0 {{ activeRouteName('integration.*') }}" style="width: 80%;">
            <a class="nav-link  d-flex flex-column align-items-center justify-content-start  {{ activeRouteName('integration.*') }}" aria-current="page" href="{{ route('integration.discord.index') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/link.svg') }}" alt="" class="icon-nav mx-2" width="18" height="18">
                <img src="{{ asset('template/images/icon/link-active.png') }}" alt="" class="icon-active  mx-2" width="18" height="18">
                @lang('page.menu_integration')
            </a>
        </li>
        @feature('creator_page')
        <li class="list-group-item border-0 py-0 mb-0 {{ activeRouteName('content.*') }}" style="width: 80%;"  >
            <a class="nav-link  d-flex flex-column align-items-center justify-content-start  py-0 mb-0  {{ activeRouteName('content.*') }}" aria-current="page" href="{{ route('content.index') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/ic-karyaof.svg') }}" alt="" class="icon-nav mx-2" width="18" height="18">
                <img src="{{ asset('template/images/icon/ic_karya.svg') }}" alt="" class="icon-active  mx-2" width="18" height="18">
                @lang('page.content')
            </a>
        </li>
        @endfeature -->
        <!-- <li class="list-group-item border-0 py-0 mb-0 {{ activeRouteName('setting.*') }}" style="width: 80%;" >
            <a class="nav-link d-flex flex-column align-items-center justify-content-start   {{ activeRouteName('setting.*') }}" aria-current="page" href="{{ route('setting.profile.index') }}" style="font-size: 16px !important;">
                <img src="{{ asset('template/images/icon/setting.png') }}" alt="" class="icon-nav mx-2" width="18" height="18">
                <img src="{{ asset('template/images/icon/settings-active.png') }}" alt="" class="icon-active  mx-2" width="18" height="18">
                @lang('page.menu_setting')
            </a>
        </li> -->
        <li class="list-group-items mr-3 mt-4 mb-4 mx-3  border-0 p-3 mb-0 d-flex flex-column justify-content-start" style="background-color: #dabaff ; border-radius: 20px;">
            <a class="text-primary" aria-current="page"href="{{route('pages.termofservice')}}  " style="font-size: 16px;">
                @lang('page.privacy_police')
            </a>
            <a class="text-primary  mt-2 " aria-current="page" href=" {{route('pages.privacypolice')}}   " style="font-size: 16px;">
                @lang('page.terms_and_condition')
            </a>

            <div class="mt-5 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <a class=" text-primary {{ activeRouteName('setting.*') }}" aria-current="page" style="font-size: 16px;">
                    {{ env('APP_NAME', 'OMG.ID | Dev ') }}
                    </a>
                    <a class="text-primary mt-2 {{ activeRouteName('setting.*') }}" aria-current="page" style="font-size: 16px;">
                        {{ env('APP_VERSION', '0.0') }}
                    </a>
                </div>
                <img src="{{ asset('template/images/omg.png') }}" alt="" class="-nav" width="40" height="40">
            </div>
        </li>

       


        <!-- <li class="list-group-item">And a fifth one</li> -->



        <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="  d-flex justify-content-center " style=" position: absolute; bottom: 40px; left: 118px;  ">
                            @csrf
                            <button class="btn btn-logout p-0 text-white iq-sign-btn" role="button">
                                    <img src="{{ asset('template/images/icon/ic-signout.png') }}" alt="" class="icon-nav mx-2" width="15" height="15">
                                     Logout
                                </button>
                            <button class="btn btn-primary w-100">
                                logout
                            </button>
                        </form> -->




    </ul>
</div>

<script>

</script>