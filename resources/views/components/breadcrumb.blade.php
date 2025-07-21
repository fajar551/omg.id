<nav aria-label="breadcrumb">
   <ol class="breadcrumb d-flex aligin-items-center mb-2">
      <li class="breadcrumb-item d-flex aligin-items-center">
         <a href=" {{ route('home') }} " class="text-breadcume">
          <img src="{{ asset('template/images/icon/homes.svg') }}" alt="" class="pb-1" width="20" height="20">  
           @lang('page.title_home')
        </a>
      </li>
      @if(is_array($pages))
        @foreach($pages as $k => $v)

            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                  {{ $v }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $k }}" class="text-dark"> {{ $v }}</a>
                </li>
            @endif
        @endforeach
      @else
        <li class="breadcrumb-item active" aria-current="page">{{$pages}}</li>
      @endif
   </ol>
</nav>
@isset($title)
  <h4 class="fw-semibold fw-subjudul mb-lg-4 mb-md-2 mb-2">{{ $title }}</h4>
@endisset