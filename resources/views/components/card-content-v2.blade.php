<div class="card card-content shadow-sm shadow-hover-sm border rounded-small inner-card-dark" data-slug="{{ $content['slug'] }}">
    <div class="img-list-content position-relative">
        <img src="{{ $content['thumbnail_path'] ?: asset('template/images/content_thumbnail.png') }}" class="img-fluid card-header-bg" alt="Content banner">

        {{-- Support Content --}}
        @if ($action == 'support')
             @php
                $blur = '';
                if ($user_id != $page['user_id']) {
                    if (isset($content['akses'])) {
                        if ($content['akses'] == 'Unpaid') {
                            $blur = 'blured'; 
                        }
                    } else {
                        $blur = 'blured';
                    }                    
                }
            @endphp
            <div class="position-absolute top-0 card-header-bg {{ $blur }}"></div>
        @endif
    </div>
    @if ($action == 'manage')
    <span class="badge {{ $content['status'] == 1 ? 'bg-success' : 'bg-warning' }} position-absolute end-0 m-3 p-2 shadow">{{ $content['formated_status'] }}</span>
    @endif
    <div class="card-body ">
        <div class="d-flex justify-content-between gap-2 content-title">
            <div class="d-flex flex-column">
                <p class="text-line-2 m-0">{{ $content['title'] }}</p>
            </div>
            <div class="d-flex flex-column">
                @if ($action == 'manage')
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm shadow-sm dropdown-toggle" type="button" id="drop-action1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                        <span class="mx-1">Kelola</span>
                    </button>
                    <ul class="dropdown-menu drop-content-action border-1 shadow rounded-small" aria-labelledby="drop-action1">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item btn-status text-dark" data-id="{{ $content['id'] }}" data-status="{{ $content['status'] == 0 ? 1 : 0 }}">
                                @if ($content['status'] == 0)
                                    <i class="fas fa-paper-plane"></i> Publish
                                @else 
                                    <i class="fas fa-save"></i> Draft
                                @endif
                            </a>
                        </li>
                        <li><a class="dropdown-item text-dark" href="{{ route('content.edit', ['id' => $content['id']]) }}"><i class="fas fa-edit"></i> Edit</a></li>
                        <li><a class="dropdown-item text-dark" href="{{ route('creator.contentdetail', ['page_name' => auth()->user()->page->page_url, 'slug' => $content['slug']]) }}"><i class="fas fa-eye"></i> View</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="javascript:void(0);" class="dropdown-item text-danger btn-delete" data-id="{{ $content->id }}"><i class="fas fa-trash"></i> Delete</a></li>
                    </ul>
                </div>
                @endif
            </div>
        </div>

        {{-- Support Content --}}
        @if ($action == 'support')
        <div class="mt-2">
            @if ($user_id != $page['user_id'])
                @if (isset($content['akses']))
                    @if ($content['akses'] == 'Unpaid')
                        <a href="#" class="btn btn-primary shadow btn-sm w-100 btn-modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="{{ $content['id'] }}" data-qty="{{ $content['qty'] }}">
                            <span class="text-line-1" title="Beli konten ini seharga: {{ $content['price'] }}">Beli ({{ $content['price'] }})</span>
                        </a>
                    @else
                        <a href="{{ route('creator.contentdetail', ['page_name' => $pageName, 'slug' => $content['slug']]) }}" class="btn btn-primary shadow btn-sm w-100 stretched-link">
                            Lihat
                        </a>
                    @endif
                @else
                    @if ($content['price'] != 'Free')
                        <a href="#" class="btn btn-primary shadow btn-sm w-100 btn-modal stretched-link" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="{{ $content['id'] }}" data-qty="{{ $content['qty'] }}">
                            <span class="text-line-1" title="Beli konten ini seharga: {{ $content['price'] }}">Beli ({{ $content['price'] }})</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm shadow w-100">
                            Lihat (Login)
                        </a>
                    @endif
                @endif
            @else
                <a href="{{ route('creator.contentdetail', ['page_name' => $pageName, 'slug' => $content['slug']]) }}" class="btn btn-primary shadow btn-sm w-100 stretched-link">
                    Lihat
                </a>
            @endif
        </div>
        @endif

        {{-- Subscribed Content --}}
        @if ($action == 'subscribed')
            <a href="{{ route('creator.contentdetail', ['page_name' => $content['pageName'], 'slug' => $content['slug']]) }}" class="btn btn-primary shadow btn-sm w-100 stretched-link step2">
                Lihat
            </a>
        @endif
    </div>
    <div class="card-footer bg-transparent border-0">
        <div class="d-flex justify-content-between">
            <span class="text-muted w-50 text-line-1" title="{{ @$content['category'] ? $content['category']['title'] : 'Not Available' }}">
                {{ @$content['category'] ? $content['category']['title'] : 'N/A' }}
            </span>
            <span class="text-muted text-line-1">
                @if ($content['qty'] > 0)
                    <span class="me-1">{{ $content['qty']}} X</span> 
                    <img src="{{ $activeItem['icon'] }}" class="icon-25" style="object-fit:cover;" alt="Item icon">
                @else
                    <span class="badge bg-secondary me-1 text-dark">@lang('Free')</span> 
                @endif
            </span>
        </div>
    </div>
</div>