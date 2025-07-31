@extends('layouts.template-body')

@section('title')
    <title>
        @lang('page.payout_account')</title>
@endsection

@section('styles')
    <style>
        .acard {
            color: whitesmoke;
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
                    ]
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-3">
                    <div>&nbsp;</div>
                    @if (count($payout_account))
                        <a href="#" type="button" class="btn btn-outline-primary" style="height: fit-content; width: fit-content;" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus-circle me-1"></i>@lang('page.create')</a>
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
                    'link' => '<a href="#" type="button" class="btn btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus-circle"></i> ' .__('page.create') .'</a>',
                ])
            @else
                <div class="card bg-transparent shadow-none border-0">

                    <div class="card-body px-0">
                        <div class="row">
                            @foreach ($payout_account as $item)
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <!-- <div class="card shadow-lg border-0 card-payout mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-0">
                                        <h3 class="mb-0"><strong> {{ ucwords($item['channel_code']) }}
                                            @if ($item['is_primary'] == 1)
    <span class="d-iflex pointer-none ml-5 p-1" title="Primary"><i class="las la-check-circle text-success"></i></span>
    @endif
    </strong>
    </h3>
                                        <div>
                                            @if ($item['status'] == 1)
    <span class="badge bg-success mt-1 text-end">Verified</span>
@else
    <span class="badge bg-warning mt-1 text-end">Unverified</span>
    @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="py-3">
                                        <div class="row">
                                            <div class="col-5">
                                                <p>{{ __('Account Name:') }}</p>
                                            </div>
                                            <div class="col-7 text-end ">
                                                {{ ucwords($item['account_name']) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5">
                                                <p>{{ __('Account Number:') }}</p>
                                            </div>
                                            <div class="col-7 text-end">
                                                {{ ucwords($item['account_number']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer  bg-transparent ">
                                    <div class="row  d-flex align-items-center pb-3 ">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <a href="{{ route('payoutaccount.edit', ['id' => $item['id']]) }}" type="button" title="Edit" class="btn btn-primary w-100 px-1  mt-3" ><i class="las la-edit"></i> Edit</a>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <a  type="button"  class="btn  btn-outline-danger w-100 px-1  mt-3"  title="Delete " data-id="{{ $item['id'] }}" onclick="deleteConfirm(this)" ><i class="ri-delete-bin-line"></i></i> Delete</a>

                                        </div>
                                       
                                        @if ($item['is_primary'] != 1 && $item['status'] == 1)
    <div class="col-lg-12 col-md-12 pe-3 ps-3 text-center ">
                                            <button type="button" class="btn btn-outline-secondary btn-block px-1 mt-3 w-100" data-id="{{ $item['id'] }}"  onclick="setReachedConfirm(this)" title="Set as Primary"><i class="las la-flag-checkered"></i> Set Primary</button>
                                        </div>
    @endif
                                    </div>
                                </div>
                            </div> -->
                                    @if ($item['status'] == 1)
                                        @if ($item['is_primary'] != 1 && $item['status'] == 1)
                                            <div class="card shadow-lg  card-payout mb-3"
                                                style="border-radius: 20px; border: 2px solid #B7B7B7; ">
                                                <div class="card-body border-secondary" style="border-radius: 20px; ">
                                                    <div class="d-flex justify-content-end mb-0">

                                                        <div>
                                                            @if ($item['status'] == 1)
                                                                <span class="badge bg-success mt-1 text-end">Verified</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-warning mt-1 text-end">Unverified</span>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <div class="title">
                                                            <h5> {{ ucwords($item['account_name']) }}</h5>
                                                            <p class="text-muted"> {{ ucwords($item['account_number']) }}
                                                            </p>
                                                        </div>

                                                        <h3 class="mb-3"><strong> {{ ucwords($item['channel_code']) }}
                                                                @if ($item['is_primary'] == 1)
                                                                    <span class="d-iflex pointer-none ml-5 p-1"
                                                                        title="Primary"><i
                                                                            class="las la-check-circle text-success"></i></span>
                                                                @endif
                                                            </strong>
                                                        </h3>

                                                    </div>
                                                    <div style="border-bottom: 2px solid #B7B7B7;"></div>
                                                    <!-- <div class=" d-flex align-items-center justify-content-between pb-3 ">
                                
                                        <a href="{{ route('payoutaccount.edit', ['id' => $item['id']]) }}" type="button" title="Edit"class="  btn-block px-1 mt-3 w-100"><i class="las la-edit"></i> Edit</a>
                         
                                        <a type="button" class=" btn btn-block px-1 mt-3 w-100" data-id="{{ $item['id'] }}" onclick="setReachedConfirm(this)" title="Set as Primary"><i class="las la-flag-checkered"></i> Set Primary</a>
                                
                                        <a type="button" class="  btn-block px-1 mt-3 w-100" title="Delete " data-id="{{ $item['id'] }}" onclick="deleteConfirm(this)"><i class="ri-delete-bin-line"></i></i> Delete</a>
                                </div> -->
                                                    <nav class="nav d-flex justify-content-center py-3">
                                                        <a href="{{ route('payoutaccount.edit', ['id' => $item['id']]) }}"
                                                            title="Edit" class="text-primary mx-0 px-0 "
                                                            aria-current="page" href="#" style="font-size: 18px;"><i
                                                                class="las la-edit"></i>Edit <span class="mx-2">
                                                                |</span> </a>
                                                        <a class="text-primary mx-0 px-0 btn-reached" href="#"
                                                            style="font-size: 18px;" data-id="{{ $item['id'] }}"
                                                            title="Set as Primary">Set
                                                            Primary <span class="mx-2"> |</span></a>
                                                        <a class="n mx-0 px-0 text-danger d-flex btn-delete" href="#"
                                                            style="font-size: 18px;" title="Delete "
                                                            data-id="{{ $item['id'] }}"><i
                                                                class="ri-delete-bin-line me-1"></i> Delete</a>
                                                    </nav>
                                                </div>
                                            </div>
                                        @else
                                            <div class="card bg-status shadow-lg border-0 card-payout mb-3"
                                                style="border-radius: 20px;   ">
                                                <div class="card-body  "
                                                    style="border-radius: 20px; border: 3px solid #D0EE26;">
                                                    <div class="d-flex justify-content-end align-items-end mb-0">

                                                        <div>
                                                            @if ($item['status'] == 1)
                                                                <span
                                                                    class="badge bg-success mt-1 text-end">Verified</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-warning mt-1 text-end">Unverified</span>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <div class="title">
                                                            <h5> {{ ucwords($item['account_name']) }}</h5>
                                                            <p class="text-muted">
                                                                {{ ucwords($item['account_number']) }}</p>
                                                        </div>
                                                        <div>
                                                            <h3 class="mb-3"><strong>
                                                                    {{ ucwords($item['channel_code']) }}
                                                                    @if ($item['is_primary'] == 1)
                                                                        <span class="d-iflex pointer-none ml-5 p-1"
                                                                            title="Primary"><i
                                                                                class="las la-check-circle text-success"></i></span>
                                                                    @endif
                                                                </strong>
                                                            </h3>
                                                        </div>

                                                    </div>
                                                    <div style="border-bottom: 2px solid #B7B7B7;"></div>

                                                    <!-- <div >
                                        <a href="{{ route('payoutaccount.edit', ['id' => $item['id']]) }}" type="button" title="Edit" class="btn rounded-pill w-100 px-1  mt-3"><i class="las la-edit"></i> Edit</a>
                                    </div>
                                    <div >
                                        <a type="button" class="btn  w-100 rounded-pill px-1  mt-3" title="Delete " data-id="{{ $item['id'] }}" onclick="deleteConfirm(this)"><i class="ri-delete-bin-line"></i></i> Delete</a>

                                    </div> -->

                                                    <nav class="nav d-flex justify-content-center py-3">
                                                        <a href="{{ route('payoutaccount.edit', ['id' => $item['id']]) }}"
                                                            title="Edit" class="mx-0 px-0 text-primary"
                                                            aria-current="page" href="#"
                                                            style="font-size: 18px;"><i class="las la-edit me-1"></i>Edit
                                                            <span class="mx-2"> |</span> </a>
                                                        <a class=" mx-0 px-0 text-danger d-flex btn-delete" href="#"
                                                            style="font-size: 18px;" title="Delete "
                                                            data-id="{{ $item['id'] }}"><i
                                                                class="ri-delete-bin-line me-1"></i> Delete</a>
                                                    </nav>

                                                    <!-- @if ($item['is_primary'] != 1 && $item['status'] == 1)
    <div class="col-lg-12 col-md-12 pe-3 ps-3 text-center ">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill btn-block px-1 mt-3 w-100" data-id="{{ $item['id'] }}" onclick="setReachedConfirm(this)" title="Set as Primary"><i class="las la-flag-checkered"></i> Set Primary</button>
                                    </div>
    @endif -->

                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="card  shadow-lg  card-payout mb-3"
                                            style="border-radius: 20px;  border: 2px solid #B7B7B7; ">
                                            <div class="card-body border-secondary" style="border-radius: 20px;  ">
                                                <div class="d-flex justify-content-end mb-0">

                                                    <div>
                                                        @if ($item['status'] == 1)
                                                            <span class="badge bg-success mt-1 text-end">Verified</span>
                                                        @else
                                                            <span class="badge bg-warning mt-1 text-end">Unverified</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-end">
                                                    <div class="title">
                                                        <h5> {{ ucwords($item['account_name']) }}</h5>
                                                        <p class="text-muted"> {{ ucwords($item['account_number']) }}
                                                        </p>
                                                    </div>

                                                    <h3 class="mb-3"><strong> {{ ucwords($item['channel_code']) }}
                                                            @if ($item['is_primary'] == 1)
                                                                <span class="d-iflex pointer-none ml-5 p-1"
                                                                    title="Primary"><i
                                                                        class="las la-check-circle text-success"></i></span>
                                                            @endif
                                                        </strong>
                                                    </h3>

                                                </div>
                                                <!-- <hr style="border-width: 10px;" > -->
                                                <div style="border-bottom: 2px solid #B7B7B7;"></div>
                                                <nav class="nav d-flex justify-content-center py-3">
                                                    <a href="{{ route('payoutaccount.edit', ['id' => $item['id']]) }}"
                                                        title="Edit"class=" text-primary mx-0 px-0 "
                                                        aria-current="page" href="#" style="font-size: 18px;"><i
                                                            class="las la-edit me-1"></i>Edit <span class="mx-2">
                                                            |</span> </a>
                                                    <a class=" mx-0 px-0 text-primary btn-reached" href="#"
                                                        style="font-size: 18px;" data-id="{{ $item['id'] }}"
                                                        title="Set as Primary">Set
                                                        Primary <span class="mx-2"> |</span></a>
                                                    <a class="text-danger  d-flex mx-0 px-0 btn-delete" href="#"
                                                        style="font-size: 18px;" title="Delete "
                                                        data-id="{{ $item['id'] }}"><i
                                                            class="ri-delete-bin-line me-1 "></i> Hapus</a>
                                                </nav>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif
        </div>



    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('page.create') @lang('page.payout_account')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>

                <form action="{{ route('payoutaccount.create') }}" method="POST" class="mt-2 needs-validation"
                    id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))"
                    autocomplete="off">
                    <div class="modal-body">
                        @include('components.flash-message', ['flashName' => 'message'])
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="type" class="form-label">{{ __('Type') }}</label> <br>
                                    <div class="form-check custom-radio form-check-inline">
                                        <input type="radio" id="type1" name="type" data-id="1"
                                            value="1" class="form-check-input"
                                            {{ old('type') ?? 1 == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type1"> E-Wallet </label>
                                    </div>
                                    <div class="form-check custom-radio form-check-inline">
                                        <input type="radio" id="type2" data-id="2" value="2" name="type" class="form-check-input"
                                            {{ old('type') == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type2"> Bank </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="channel_code">Channel</label>
                                    <select class="form-select" id="channel_code" name="channel_code">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="account_name">{{ __('Account Name') }} *</label>
                                    <input name="account_name" type="text" id="account_name"
                                        class="form-control mb-0 @error('account_name') is-invalid @enderror"
                                        value="{{ old('account_name') }}" placeholder="@lang('form.lbl_full_name')" required>
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="account_number">{{ __('Account Number') }} *</label>
                                    <input name="account_number" type="text" id="account_number"
                                        class="form-control mb-0 @error('account_number') is-invalid @enderror"
                                        value="{{ old('account_number') }}"
                                        placeholder="{{ __('Your Account Number') }}" required>
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
                    setReachedConfirm($(this));
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
                        const {
                            data
                        } = response;
                        const {
                            message,
                            status
                        } = data;

                        var str = ""
                        if (id == 2) {
                            for (var item of data.data.bank) {
                                if ('{{ old('channel_code') }}' == item['channel_code']) {
                                    str += "<option value='" + item['channel_code'] + "' selected>" + item[
                                        'title'] + "</option>"
                                } else {
                                    str += "<option value='" + item['channel_code'] + "'>" + item['title'] +
                                        "</option>"
                                }
                            }
                        } else {
                            for (var item of data.data.ewallet) {
                                if ('{{ old('channel_code') }}' == item['channel_code']) {
                                    str += "<option value='" + item['channel_code'] + "' selected>" + item[
                                        'title'] + "</option>"
                                } else {
                                    str += "<option value='" + item['channel_code'] + "'>" + item['title'] +
                                        "</option>"
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

                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    html: "{!! __('You will permanently <cite>\"Delete\"</cite> this data.') !!}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#50b5ff",
                    confirmButtonText: "{{ __('OK') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(el).attr({
                            "disabled": true
                        }).html("Loading...");
                        $('#delete-id').val(id);
                        $('#delete-form').submit();
                    }
                }).catch(swal.noop);
            }

            const setReachedConfirm = (el) => {
                const id = $(el).attr("data-id");
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    html: "{!! __('You will set this account as <cite>\"Primary\"</cite>.') !!}",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#50b5ff",
                    confirmButtonText: "{{ __('OK') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(el).attr({
                            "disabled": true
                        }).html("Loading...");
                        $('#set-primaryid').val(id);
                        $('#set-primary-form').submit();
                    }
                }).catch(swal.noop);
            }

        })(jQuery);
    </script>
@endsection
