@extends('layouts.template-body')

@section('title')
    <title>@lang('page.payout_account')</title>
@endsection

@section('styles')
    <style>
        .acard {
            color: whitesmoke;
        }
    </style>
@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.edit') .' ' . __('page.payout_account'), 
                    'pages' => [ 
                        route('payoutaccount.index') => __('page.payout_account'), 
                        '#' => __('page.title_edit') 
                    ]
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('payoutaccount.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="number" name="id" value="{{ $data["id"] }}" hidden>
                    <div class="card border-0 shadow rounded-small card-dark">
                        <div class="card-body ">

                            @include('components.flash-message', ['flashName' => 'message'])
                        
                            <div class="form-group mb-3">
                                <div class="row d-flex align-items-center">
                                    <label for="type" class="col-sm-3 form-label m-0">{{ __('Type') }} <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="form-check custom-radio form-check-inline">
                                            <input type="radio" id="type1" name="type" value="1" data-id="1" onclick="showCreateModal(1)" class="form-check-input" {{ old('type', $data["type"]) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type1"> E-Wallet </label>
                                        </div>
                                        <div class="form-check custom-radio form-check-inline">
                                            <input type="radio" id="type2" value="2" name="type" data-id="2" onclick="showCreateModal(2)" class="form-check-input" {{ old('type', $data["type"]) == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type2"> Bank </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row d-flex align-items-center">
                                    <label for="type" class="col-sm-3 form-label m-0" for="channel_code">Channel <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-select @error('channel_code') is-invalid @enderror" id="channel_code" name="channel_code" required>
                                        
                                        </select>
                                        @error('channel_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row d-flex align-items-center">
                                    <label for="type" class="col-sm-3 form-label m-0" for="account_name">{{ __('Account Name') }} <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input name="account_name" type="text" id="account_name" class="form-control rounded mb-0 @error('account_name') is-invalid @enderror" value="{{ old('account_name', $data["account_name"]) }}" placeholder="@lang('form.lbl_full_name')" required>
                                        @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row d-flex align-items-center">
                                    <label for="type" class="col-sm-3 form-label m-0" for="account_number">{{ __('Account Number') }} <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input name="account_number" type="text" id="account_number" class="form-control rounded r mb-0 @error('account_number') is-invalid @enderror" value="{{ old('account_number', $data["account_number"]) }}" placeholder="{{ __('Your Account Number') }}" required>
                                        @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-3">
                            <div class="d-flex justify-content-md-end justify-content-center gap-2">
                                <a href="{{ route('payoutaccount.index') }}" class="btn btn-outline-danger rounded-pill">@lang('form.btn_cancel')</a>
                                <button type="button" onclick="updateConfirm(this)" id="btn-submit" class="btn rounded-pill btn-primary">{{ __('form.btn_submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript">
        $(()=>{

            @error('account_number')
                $('#exampleModal').modal("show");
            @enderror
            @error('account_name')
                $('#exampleModal').modal("show");
            @enderror
            
            var id = {{ old('type') ?? $data["type"] }};
            console.log(id);
            showCreateModal(id);
            
        });

        const showCreateModal = async (id) => {
            let authToken = document.head.querySelector('meta[name="auth"]');
            var url = "{{url('api/payoutchannel/getchannel')}}";
            await axios.get(url)
                .then(function (response) {
                    const { data } = response;
                    const { message, status } = data;
                    
                    var str = ""
                    if (id == 2) {
                        for (var item of data.data.bank) {
                            if ("{{ old('channel_code') ?? $data['channel_code'] }}"==item['channel_code']) {
                                str += "<option value='" + item['channel_code'] + "' selected>" + item['title'] + "</option>"
                            }else{
                                str += "<option value='" + item['channel_code'] + "'>" + item['title'] + "</option>"
                            }
                        }
                    } else {
                        for (var item of data.data.ewallet) {
                            if ("{{ old('channel_code') ?? $data['channel_code'] }}"==item['channel_code']) {
                                str += "<option value='" + item['channel_code'] + "' selected>" + item['title'] + "</option>"
                            }else{
                                str += "<option value='" + item['channel_code'] + "'>" + item['title'] + "</option>"
                            }
                        }
                    }
                    document.getElementById("channel_code").innerHTML = str;
                    // console.log(data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        
        const updateConfirm = (el) => {
            ToastConfirm.fire({
                title: "{{ __('Are you sure edit this account?') }}",
                html: "{!! __('You will not be able to make a disbursement with this account while the approval process is still in progress. Continue?') !!}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(el).attr({"disabled": true}).html("Loading...");
                    $('#input-form').submit();
                }
            });
        }
    </script>
@endsection