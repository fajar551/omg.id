@extends('layouts.template-body')

@section('title')
    <title>@lang('page.item')</title>
@endsection

@section('styles')
    <style>
        .card-items {
            min-height: 150px;
        }

        .card-add-new {
            min-height: 255px;
        }

        .card-footer-item .btn-setactive i {
            color: #2a9f25;
        }

        .card-footer-item .btn-edit i {
            color: #6103D0;
        }

        .card-footer-item .btn-delete i {
            color: #F74D5A;
        }

        .card-items.active {
            border: solid 2px #D0EE26 !important;
        }

        .item-thumbnail img {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }

        .item-info {
            margin: 0 8px 0 8px;
        }

        .item-description {
            min-height: 57px;
        }

        @media(max-width: 768px) {
            .card-item-info {
                flex-direction: column;
            }

            .item-thumbnail {
                margin: auto !important;
            }

            .item-thumbnail img {
                width: 100px;
                height: 100px;
            }

            .item-info {
                margin: 8px 0 0 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.item_list'),
                    'pages' => [
                        '#' => __('page.item'),
                    ],
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>

        @if (!count($data))
            @include('components.is-empty-data', [
                'message' => 'Anda belum memiliki Item',
                'text' => '',
                'link' => [
                    [
                        'url' => route('item.create'),
                        'icon' => '<i class="las la-plus-circle"></i>',
                        'title' => __('page.create_new_item'),
                    ],
                ],
            ])
        @else
            <section class="section-item mb-5">
                <div class="container">
                    <div class="row step11">
                        @foreach ($data as $item)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                <div class="card card-items card-hover rounded-small shadow border-0 p-0 mb-3 {{ $item['is_active'] == true ? 'active' : '' }}">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <div class="d-flex justify-content-end m-2">
                                            @if ($item['is_active'])
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="">&nbsp;</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div class="d-flex align-items-start card-item-info w-100">
                                                <div class="text-center item-thumbnail">
                                                    <a href="javascript:void(0);" id="btn-change-icon" data-id="{{ $item['id'] }}">
                                                        <img src="{{ $item['icon'] ?? asset('assets/img/default-item.svg') }}" id="pm-icon-{{ $item['id'] }}" alt="profile-img" class="rounded-circle border border-1 shadow-sm">
                                                    </a>
                                                </div>
                                                <div class="item-info">
                                                    <h4 class="text-line-1" title="{{ $item['name'] }}">{{ $item['name'] }}</h4>
                                                    <p class="mb-0 text-line-1" title="{{ $item['formated_price'] }}">{{ $item['formated_price'] }}</p>
                                                    <hr class="mt-2">
                                                    <div class="item-description">
                                                        <p class="mb-0 text-line-2" title="{{ $item['description'] ?? '-' }}">{{ $item['description'] ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 ">
                                        <div class="card-footer-item d-flex gap-3 align-items-center justify-content-end">
                                            @if (!$item['is_active'])
                                                <a type="button" class="btn-setactive p-0 fs-5 " id="btn-activate" data-id="{{ $item['id'] }}" title="Set sebagai aktif"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="{{ route('item.edit', ['id' => $item['id']]) }}" class="btn-edit p-0 fs-5" data-id="{{ $item['id'] }}" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a type="button" class="btn-delete p-0 fs-5" id="btn-delete" data-id="{{ $item['id'] }}" title="Hapus"><i class="fa fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($loop->last)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card card-add-new card-hover border-0 rounded-small shadow step12">
                                        <div class="card-header bg-transparent border-0 p-0 ">
                                            <div class="d-flex justify-content-end m-2">
                                                <span class="">&nbsp;</span>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex justify-content-center align-items-center  text-center py-2">
                                            <a href="{{ route('item.create') }}" class="text-dark">
                                                <svg width="49" height="49" viewBox="0 0 59 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="28.5273" width="2.59341" height="59" rx="1.2967" fill="black" />
                                                    <rect y="30.4727" width="2.59341" height="59" rx="1.2967" transform="rotate(-90 0 30.4727)" fill="black" />
                                                </svg>
                                                <p class="fs-5 fw-semibold mt-3">Buat Item Baru</p>
                                            </a>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 ">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <form action="{{ route('item.setactive') }}" method="POST" id="set-primary-form" hidden>
                            @csrf
                            <input type="hidden" name="id" id="active-id" value="" required />
                        </form>
                        <form action="{{ route('item.delete') }}" method="post" id="delete-form" hidden>
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="delete-id" value="" required />
                        </form>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="preview-modal-label" aria-hidden="true">
        <div class="modal-md modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="preview-modal-label">@lang('Preview')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('item.changeicon') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                    @csrf
                    @method('POST')
                    <input type="number" name="id" id="pm-icon-id" required hidden>
                    <div class="modal-body">

                        @include('components.flash-message', ['flashName' => 'message'])

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <div class="table-responsive text-center">
                                        <img id="enlarge-img-prev" src="" class="img-fluid rounded" style="width: 120px; height: 120px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="pm-icon-file" class="form-label custom-file-input @error('icon') is-invalid @enderror">@lang('Change Icon')</label>
                                    <input class="form-control" type="file" name="icon" id="pm-icon-file" onchange="document.getElementById('enlarge-img-prev').src = window.URL.createObjectURL(this.files[0])" accept="image/*" required>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn-submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/guide/item.js') }}"></script>
    <script type="text/javascript">
        /**
         * Manage item index script
         * Version: 1.0
         */
        (function($) {


            const deleteConfirm = (el) => {
                const id = $(el).attr("data-id");

                ToastDelete.fire({
                    title: langGet('page.are_you_sure'),
                    html: langGet('page.sure_delete'),
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(el).attr({
                            "disabled": true
                        });
                        $('#delete-id').val(id);
                        $('#delete-form').submit();
                    }
                }).catch(swal.noop);
            }

            const setActivate = (el) => {
                const id = $(el).attr("data-id");

                ToastConfirm.fire({
                    title: langGet('page.are_you_sure'),
                    html: langGet('page.sure_set_active_item'),
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(el).attr({
                            "disabled": true
                        });
                        $('#active-id').val(id);
                        $('#set-primary-form').submit();
                    }
                }).catch(swal.noop);
            }

            const changeIcon = (id) => {
                new bootstrap.Modal($('#preview-modal'), {
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                }).show();

                $("#pm-icon-file").val(null);
                $('#pm-icon-id').val(id);
                $('#enlarge-img-prev').attr('src', $(`#pm-icon-${id}`).attr('src'));
            }

            @error('icon')
                changeIcon({{ old('id') }});
            @enderror

            $(document).on('click', '#btn-change-icon', function(e) {
                changeIcon($(this).attr('data-id'));
            });

            $(document).on('click', '#btn-activate', function(e) {
                setActivate(this);
            });

            $(document).on('click', '#btn-delete', function(e) {
                deleteConfirm(this);
            });

        })(jQuery);
    </script>
@endsection
