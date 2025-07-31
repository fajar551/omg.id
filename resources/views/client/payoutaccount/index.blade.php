@extends('layouts.template-body')

@section('title')
    <title>
        @lang('page.payout_account')</title>
@endsection

@section('styles')
    <style>
        .card-payout {
            /* color: whitesmoke; */
            border-radius: 10px;
            border: 2px solid transparent !important;
            /* border-radius: 20px; border: 2px solid #B7B7B7; */
        }

        .card-payout.active {
            border: 2px solid #D0EE26 !important;
            background-color: #f9ffd5;
        }

        .bg-status {
            background-color: #ECFFF6;
        }
    </style>
@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.list_payout_account'),
                    'pages' => [
                        '#' => __('page.payout_account'),
                    ],
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-3">
                    <div>&nbsp;</div>
                    @if (count($payout_account))
                        <a href="#" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-plus me-1"></i>@lang('page.create')</a>
                    @endif
                </div>
            </div>
        </div>

        @include('components.flash-message', ['flashName' => 'message'])

        <div class="payoutsection">
            @if (!count($payout_account))
                @include('components.is-empty-data', [
                    'message' => __('You don\'t have any payout account.'),
                    'text' => 'Please create one active payout account by click <cite>"Create"</cite> Button or click link bellow',
                    'link' => '<a href="#" type="button" class="btn btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus-circle"></i> ' . __('page.create') . '</a>',
                ])
            @else
                <div class="card bg-transparent shadow-none border-0">
                    <div class="card-body px-0">
                        <div class="row">
                            @foreach ($payout_account as $item)
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="card shadow card-payout mb-3 card-dark @if ($item['is_primary'] == 1) active @endif">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-end mb-0">
                                                <div>
                                                    @if ($item['status'] == 1)
                                                        <span class="badge bg-success mt-1 text-end">Verified</span>
                                                    @else
                                                        <span class="badge bg-danger mt-1 text-end">Unverified</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div class="title">
                                                    <h5 class="text-line-1"> {{ ucwords($item['account_name']) }}</h5>
                                                    <p class="text-muted text-line-1"> {{ ucwords($item['account_number']) }}</p>
                                                </div>
                                                <h6 class="mt-1 text-line-1">
                                                    <strong> {{ strtoupper($item['channel_code']) }}
                                                        @if ($item['is_primary'] == 1)
                                                            <span class="text-primary" title="Akun Utama"><i class="fa fa-check-circle"></i></span>
                                                        @endif
                                                    </strong>
                                                </h6>
                                            </div>
                                            <hr class="mt-0 mb-1">
                                            <nav class="nav d-flex justify-content-center py-2">
                                                <a class="text-primary" href="{{ route('payoutaccount.edit', ['id' => $item['id']]) }}" title="Edit" aria-current="page" href="#">
                                                    <small>Edit</small>
                                                </a>
                                                <span class="mx-2 text-muted"> &bullet; </span>
                                                @if ($item['is_primary'] != 1 && $item['status'] == 1)
                                                    <a class="text-primary btn-reached" href="#" data-id="{{ $item['id'] }}" title="Setel sebagai akun pencairan utama">
                                                        <small>Set Primary</small>
                                                    </a>
                                                    <span class="mx-2 text-muted"> &bullet; </span>
                                                @endif
                                                <a class="text-danger btn-delete" href="#" title="Delete " data-id="{{ $item['id'] }}">
                                                    <small>Delete</small>
                                                </a>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('page.create') @lang('page.payout_account')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>

                <form action="{{ route('payoutaccount.create') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                    <div class="modal-body">
                        @include('components.flash-message', ['flashName' => 'message'])
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">{{ __('Type') }} <span class="text-danger">*</span></label> <br>
                                    <div class="form-check custom-radio form-check-inline">
                                        <input type="radio" id="type1" name="type" data-id="1" value="1" class="form-check-input" {{ old('type') ?? 1 == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type1"> E-Wallet </label>
                                    </div>
                                    <div class="form-check custom-radio form-check-inline">
                                        <input type="radio" id="type2" data-id="2" value="2" name="type" class="form-check-input" {{ old('type') == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type2"> Bank </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="channel_code">Channel <span class="text-danger">*</span></label>
                                    <select class="form-select" id="channel_code" name="channel_code">

                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="account_name">{{ __('Account Name') }} <span class="text-danger">*</span></label>
                                    <input name="account_name" type="text" id="account_name" class="form-control @error('account_name') is-invalid @enderror" value="{{ old('account_name') }}" placeholder="@lang('form.lbl_full_name')" required>
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="account_number">{{ __('Account Number') }} <span class="text-danger">*</span></label>
                                    <input name="account_number" type="text" id="account_number" class="form-control @error('account_number') is-invalid @enderror" value="{{ old('account_number') }}" placeholder="{{ __('Your Account Number') }}" required>
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn-submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form action="{{ route('payoutaccount.setprimary') }}" method="POST" id="set-primary-form" hidden>
        @csrf
        <input type="hidden" id="set-primaryid" name="id" required />
    </form>
    <form action="{{ route('payoutaccount.delete') }}" method="post" id="delete-form" hidden>
        @csrf
        @method('post')
        <input type="hidden" name="id" id="delete-id" required />
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript">
        (function($) {
            "use strict";

            $(() => {
                @error('account_number')
                    $('#exampleModal').modal("show");
                @enderror

                @error('account_name')
                    $('#exampleModal').modal("show");
                @enderror

                var id = {{ old('type') ?? old('type') == 2 ? 2 : 1 }};
                showCreateModal(id);

                $(".form-check-input").on("click", function() {
                    var id = $(this).data('id');
                    showCreateModal(id);
                });

                $(".btn-reached").on("click", function() {
                    setAsPrimary($(this));
                });

                $(".btn-delete").on("click", function() {
                    deleteConfirm($(this));
                });
            });

            const showCreateModal = async (id) => {
                let authToken = document.head.querySelector('meta[name="auth"]');
                var url = "{{ url('api/payoutchannel/getchannel') }}";

                await axios.get(url)
                    .then(function(response) {
                        const { data } = response;
                        const { message, status } = data;

                        var str = ""
                        if (id == 2) {
                            for (var item of data.data.bank) {
                                if ('{{ old('channel_code') }}' == item['channel_code']) {
                                    str += "<option value='" + item['channel_code'] + "' selected>" + item['title'] + "</option>"
                                } else {
                                    str += "<option value='" + item['channel_code'] + "'>" + item['title'] + "</option>"
                                }
                            }
                        } else {
                            for (var item of data.data.ewallet) {
                                if ('{{ old('channel_code') }}' == item['channel_code']) {
                                    str += "<option value='" + item['channel_code'] + "' selected>" + item['title'] + "</option>"
                                } else {
                                    str += "<option value='" + item['channel_code'] + "'>" + item['title'] + "</option>"
                                }
                            }
                        }
                        document.getElementById("channel_code").innerHTML = str;
                        // console.log(data);
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }

            const deleteConfirm = (el) => {
                const id = $(el).attr("data-id");

                ToastDelete.fire({
                    title: "{{ __('Are you sure?') }}",
                    html: "{!! __('You will permanently <cite>\"Delete\"</cite> this data.') !!}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(el).attr({"disabled": true}).html("Loading...");
                        $('#delete-id').val(id);
                        $('#delete-form').submit();
                    }
                }).catch(swal.noop);
            }

            const setAsPrimary = (el) => {
                const id = $(el).attr("data-id");

                ToastConfirm.fire({
                    title: "{{ __('Are you sure?') }}",
                    html: "{!! __('You will set this account as <cite>\"Primary\"</cite>.') !!}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(el).attr({"disabled": true}).html("Loading...");
                        $('#set-primaryid').val(id);
                        $('#set-primary-form').submit();
                    }
                }).catch(swal.noop);
            }
        })(jQuery);
    </script>
@endsection
