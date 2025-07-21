@foreach ($content['data'] as $item)
    <div class="col-xl-4 col-md-6 col-sm-12 px-md-1 px-sm my-3">
        <div class="card card-content shadow-sm rounded-xsmall border-0">
            <div class="position-relative text-center">
                <img src="{{ $item['thumbnail'] ?: asset('template/images/bg-gradient.png') }}" class="card-img-top" alt="..." style="border-radius: 10px 10px 0px 0px !important; max-height: 150px; object-fit: cover; min-height: 150px;">
                <div class="bg-card-creator position-absolute" style="border-radius: 10px 10px 0px 0px !important;
                    @if ($user_id != $page['user_id']) 
                        @if (isset($item['akses']))
                            {{ $item['akses'] == 'Unpaid' ? ' backdrop-filter: blur(5px);' : '' }}
                        @else
                            {{ ' backdrop-filter: blur(5px);' }} 
                        @endif
                    @endif">
                </div>
            </div>
            <span class="badge bg-success shadow position-absolute end-0 px-2 py-2 label-content ms-2 mt-2">{{ $item['price'] == 'Free' ? ' Free' : '' }}</span>
            <div class="card-body">
                <div class="content-title">
                    <p class="card-text creator my-0 text-line-2">
                        {{ $item['title'] }}
                    </p>
                </div>
                <div class="d-flex align-items-end" style="min-height: 50px; overflow: hidden">
                    @if ($user_id != $page['user_id'])
                        @if (isset($item['akses']))
                            @if ($item['akses'] == 'Unpaid')
                                <a href="#" class="btn btn-primary rounded-pill btn-sm w-100 mt-2 stretched-link btn-modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="{{ $item['id'] }}" data-qty="{{ $item['qty'] }}">
                                    <span class="text-line-1" title="{{ $item['price'] }}"><img src="{{ $item['item_icon'] }}" style="width: 25px;" alt="">{{ $item['price'] }}</span>
                                </a>
                            @else
                                <a href="{{ route('creator.contentdetail', ['page_name' => $pageName, 'slug' => $item['slug']]) }}" class="btn btn-primary rounded-pill btn-sm w-100 mt-2 stretched-link">
                                    Lihat
                                </a>
                            @endif
                        @else
                            @if ($item['price'] != 'Free')
                                <a href="#" class="btn btn-primary rounded-pill btn-sm w-100 mt-2 stretched-link btn-modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="{{ $item['id'] }}" data-qty="{{ $item['qty'] }}">
                                    <span class="text-line-1" title="{{ $item['price'] }}"><img src="{{ $item['item_icon'] }}" style="width: 25px;" alt="">{{ $item['price'] }}</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill btn-sm w-100 mt-2 stretched-link">
                                    Lihat (Login)
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('creator.contentdetail', ['page_name' => $pageName, 'slug' => $item['slug']]) }}" class="btn btn-primary rounded-pill btn-sm w-100 mt-2 stretched-link">
                            Lihat
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
