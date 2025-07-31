<div class="col-12 d-lg-none d-sm-block">
    <div class="d-flex justify-content-end dropdown mb-3 ">
        <button class="btn btn-outline-primary d-flex justify-content-between align-items-center dropdown-mobile" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" style="width: 154px; border-radius: 8px;"  aria-expanded="false">
           {{ $widget_with_settings['name'] }}
           <i class="fas fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end rounded-small border-1 shadow" aria-labelledby="dropdownMenuButton1">
            @foreach($widgets as $widget)
            <li><a class="dropdown-item  {{ ( $widget_with_settings['key'] == $widget['key']  )?'active':'' }}" href="{{ route('overlay.notification',['key' =>  $widget['key'] ]) }}" href="#">{{ $widget['name'] }} </a></li>
            @endforeach
        </ul>
    </div>
</div>

