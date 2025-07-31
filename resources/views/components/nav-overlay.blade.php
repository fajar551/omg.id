{{-- <div class="card shadow border-0 rounded-3  mb-3">
   <div class="card-body">
      <ul class="nav nav-pills nav-fill mx-0 px-0" id="pills-tab-1" role="tablist">
         @foreach($widgets as $widget)
         <li class="nav-item">
            <a class="nav-link tab-nav {{ ( $widget_with_settings['key'] == $widget['key']  )?'active':'' }}" href="{{ route('overlay.notification',['key' =>  $widget['key'] ]) }}" style="font-weight: bold !important;">{{ $widget['name'] }}</a>
         </li>
         @endforeach
      </ul>
   </div>
</div> --}}

<nav class="nav d-flex justify-content-around align-items-center w-100 p-2 bg-white shadow mb-3 rounded-small">
   @php
       $no = 11;
   @endphp
   @foreach($widgets as $widget)
      <a class="nav-link goal text-center text-dark step{{$no}} {{ ($widget_with_settings['key'] == $widget['key']) ? 'active' : '' }}" href="{{ route('overlay.notification',['key' =>  $widget['key'] ]) }}">{{ $widget['name'] }}</a>
      @php
          $no++;
      @endphp
   @endforeach
</nav>