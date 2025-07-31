<div class="container p-2">
    <div class="">
        <div class="d-flex flex-column align-items-center py-5 mb-5">
            <img src="{{ asset('template/images/condition-undifined.svg') }}" alt="" class="" width="400" >
            <div class="mt-4 mb-2 text-center"  >
                <h5 class="fw-semibold">
                    {!! $message !!}
                </h5>
                @if($text)
                    <p>{!! $text !!}</p>
                @endif
            </div>
            <div >
                @if(is_array($link))
                    @foreach($link as $v)
                        <a href="{{ $v['url'] }}" title="{{ $v['title'] }}" type="button" class="btn btn-primary mb-1 step11">@if($v['icon']) {!! $v['icon'] !!}   @endif {{ $v['title'] }}</a>
                    @endforeach
                @else
                    {!! $link !!}
                @endif
            </div>
        </div>
    </div>
</div>