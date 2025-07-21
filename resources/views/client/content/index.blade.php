@extends('layouts.template-body')

@section('title')
    <title>@lang('Manage Content')</title>
@endsection

@section('styles')

@endsection

@section('content')
    <div class="container px-5 mb-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.content_list'), 
                    'pages' => [
                        '#' => __('Konten'),
                    ]
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>
        <div class="step11">
        @if (!count($data['contents']))
            @include('components.is-empty-data', [
                'message' => __('Yuk buat konten dan hasilkan uang'),
                'text' => '',
                'link' => [
                    [
                        'url' => route('content.create'),
                        'icon' => '<i class="las la-plus-circle"></i>',
                        'title' => __('Buat Konten')
                    ]
                ]])
        @else
            <div class="row d-flex justify-content-end px-2">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <a href="{{ route('content.create') }}" class="btn btn-light shadow-sm d-flex align-items-center justify-content-center step12">
                        <span class="mx-1 text-dark"><i class="fas fa-plus"></i> @lang('Buat Konten')</span>
                    </a>

                </div>
            </div>
            <div class="row mt-4">
                @foreach ($data['contents'] as $content)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3">
                    @include('components.card-content-v2', [
                        'content' => $content, 
                        'activeItem' => $activeItem,
                        'action' => 'manage'
                    ])
                    
                    {{-- <div class="card card-content shadow border-0 rounded-small">
                        <div class="img-list-content position-relative">
                            <img src="{{ $content->thumbnail_path ?: asset('template/images/bg-gradient.png') }}" class="img-fluid card-header-bg" alt="Content banner">
                            <div class="position-absolute top-0 card-header-bg blured"></div>
                        </div>
                        <span class="badge {{ $content->status == 1 ? 'bg-success' : 'bg-warning' }} position-absolute end-0 m-3 p-2 shadow">{{ $content->formated_status }}</span>
                        <div class="card-body ">
                            <div class="d-flex justify-content-between gap-2 content-title">
                                <div class="d-flex flex-column">
                                    <p class="text-line-2">{{ $content->title }}</p>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="drop-action1" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 5px;">
                                            <i class="fas fa-cog"></i>
                                            <span class="mx-1">Kelola</span>
                                        </button>
                                        <ul class="dropdown-menu drop-content-action border-1 shadow rounded-small" aria-labelledby="drop-action1">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item btn-status text-dark" data-id="{{ $content->id }}" data-status="{{ $content->status == 0 ? 1 : 0 }}">
                                                    @if ($content->status == 0)
                                                    <i class="fas fa-paper-plane"></i> Publish
                                                    @else 
                                                    <i class="fas fa-save"></i> Draft
                                                    @endif
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item text-dark" href="{{ route('content.edit', ['id' => $content->id]) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                            <li><a class="dropdown-item text-dark" href="{{ route('creator.contentdetail', ['page_name' => auth()->user()->page->page_url, 'slug' => $content->slug]) }}"><i class="fas fa-eye"></i> View</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a href="javascript:void(0);" class="dropdown-item text-danger btn-delete" data-id="{{ $content->id }}"><i class="fas fa-trash"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">
                                    {{ $content->category ? $content->category->title : 'N/A' }}
                                </span>
                                <span class="text-muted">
                                    @if ($content->qty > 0)
                                        <span class="me-1">{{ $content->qty}} X</span> 
                                        <img src="{{ $activeItem['icon'] }}" class="" style="width: 25px; height: 25px; object-fit:cover;" alt="Item icon">
                                    @else
                                        <span class="badge bg-secondary me-1 text-dark">@lang('Free')</span> 
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div> --}}
                </div>
                @endforeach
                <form action="{{ route('content.delete') }}" method="POST" id="delete-form" hidden>
                    @csrf
                    @method("DELETE")
                    <input type="hidden" name="id" id="delete-id" required />
                </form>
                <form action="{{ route('content.status') }}" method="POST" id="status-form" hidden>
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="id" id="status-id" required />
                    <input type="hidden" name="status" id="data-status" required />
                </form>
            </div>
            <div class="row mt-5">
                <div class="col-lg-12 col-sm-12 d-flex justify-content-center">
                    {{ $data['meta']->links() }}
                </div>
            </div>
        @endif
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/guide/content.js') }}"></script>
    <script>
        /**
        * Manage content index script
        * Version: 1.0
        */
        (function ($) {
            "use strict";

            const pageName = '{{ auth()->user()->page->page_url }}';

            $(document).on('click', '.btn-delete', function(e) {
                let id = $(this).attr('data-id');

                ToastDelete.fire({
                    title: '@lang("page.sure")',
                    html: '@lang("page.sure_delete")',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-id').val(id);
                        $('#delete-form').submit();
                    }
                });
            });

            $(document).on('click', '.btn-status', function(e) {
                let id = $(this).attr('data-id');
                let status = $(this).attr('data-status');

                ToastConfirm.fire({
                    title: '@lang("page.sure")',
                    html: '@lang("page.sure_status_change")',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#status-id').val(id);
                        $('#data-status').val(status);
                        $('#status-form').submit();
                    }
                });
            });

            $(document).on('click', '.card-content', function(e) {
                let slug = $(this).attr('data-slug');
                // window.location = '{{ route('creator.contentdetail', ['page_name' => "#page_name", 'slug' => "#slug"]) }}'.replace('#page_name', pageName).replace('#slug', slug);
            });
        })(jQuery);
    </script>
@endsection