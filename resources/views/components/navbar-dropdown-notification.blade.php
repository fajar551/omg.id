<div class="dropdown my-auto step9">
    @php
      $unreadNotifCount = auth()->user()->unreadNotifications->count();
    @endphp
    <a href="#" class="nav-link dropdown-toggle p-1 badge-notif" id="notification-drop" data-unread="{{ $unreadNotifCount }}"  data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
        <span class="badge-notification bg-danger position-absolute top-10 translate-middle text-sm text-center" id="notif-badge"> 
          <span style="font-size: 10px; @if($unreadNotifCount == 0) display:none; @endif">&nbsp;</span> 
        </span>
        <img src="{{ asset('template/images/icon/ic-notification-inactive.png') }}" alt="" class="icon-nav mx-2 icon-20">
    </a>
    <ul class="dropdown-menu {{ $dropMode ?? 'dropdown-menu-md-end dropdown-menu-sm-start' }} p-0 border-0 position-absolute" aria-labelledby="notification-drop">
        <div class="card shadow m-0 show-notification border-0 rounded-small bg-light">
            <div class="card-header border-0 d-flex justify-content-between bg-transparent rounded-top-small">
                <div class="header-title">
                    <h5 class="mb-1 text-dark"> Notifications</h5>
                    <a href="javascript:void(0);" class="btn btn-link p-0 text-primary" id="mark-all-read">
                        <small class="" id="mark-all-text">Mark All as Read</small>
                    </a>
                </div>
                <span class="badge text-dark fs-6" id="notif-count">{{ $unreadNotifCount }}</span>
            </div>
            <div class="card-body card-notification p-0 bg-transparent">
              <div class="bg-white" id="div-notify" data-template="1">
                
              </div>
            </div>
            <div class="card-footer border-0 p-2 text-center bg-white rounded-bottom-small" id="div-notify-footer">
                {{-- <button class="btn btn-link"> Load More </button> --}}
            </div>
        </div>
    </ul>
</div>