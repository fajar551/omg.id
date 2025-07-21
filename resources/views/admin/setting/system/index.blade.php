@extends('layouts.admin.omg')

@section('title',  __('Setting - System'))

@section('styles')

@endsection

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-soft-primary">
                       <li class="breadcrumb-item">
                           <a href="{{ route('admin.home') }}"><i class="ri-home-4-line me-1"></i>@lang('page.title_home')</a>
                        </li>
                       <li class="breadcrumb-item">@lang('Setting')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('System')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('System')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])

                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('admin.setting.system.storepaymentfee') }}" method="POST" class="mt-2 needs-validation" id="system-setting-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                                    @csrf
                                    <div class="card mb-4">
                                        <div class="card-header card-dark-80 d-flex justify-content-between">
                                            <div class="header-title">
                                                <h5 class="card-title">@lang('Payment Fee')</h5>
                                            </div>
                                            <div class="card-header-toolbar d-flex align-items-center">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="card-body card-dark-80">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('QRIS') (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[qris]" min="0" step="0.1" max="100" class="form-control @error('qris') is-invalid @enderror" placeholder="@lang('QRIS')" value="{{ old('settings.qris', $settings['qris']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('qris')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Gopay') (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[gopay]" min="0" step="0.1" max="100" class="form-control @error('gopay') is-invalid @enderror" placeholder="@lang('Gopay')" value="{{ old('settings.gopay', $settings['gopay']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('gopay')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Dana') (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[dana]" min="0" step="0.1" max="100" class="form-control @error('dana') is-invalid @enderror" placeholder="@lang('Dana')" value="{{ old('settings.dana', $settings['dana']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('dana')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('OVO') (%)</label>
                                                            <div class="input-group">
                                                            <input type="number" name="settings[ovo]" min="0" step="0.1" max="100" class="form-control @error('ovo') is-invalid @enderror" placeholder="@lang('OVO')" value="{{ old('settings.ovo', $settings['ovo']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('ovo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Link Aja') (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[linkaja]" min="0" step="0.1" max="100" class="form-control @error('linkaja') is-invalid @enderror" placeholder="@lang('Link Aja')" value="{{ old('settings.linkaja', $settings['linkaja']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('linkaja')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Shope Pay') (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[shopeepay]" min="0" step="0.1" max="100" class="form-control @error('shopeepay') is-invalid @enderror" placeholder="@lang('Shope Pay')" value="{{ old('settings.shopeepay', $settings['shopeepay']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('shopeepay')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Platform Fee') (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[platform_fee]" min="0" step="0.1" max="100" class="form-control @error('platform_fee') is-invalid @enderror" placeholder="@lang('Platform Fee')" value="{{ old('settings.platform_fee', $settings['platform_fee']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('platform_fee')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Bank Transfer')</label>
                                                        <input type="number" name="settings[bank_transfer]" min="0" step="100" max="100000" class="form-control @error('bank_transfer') is-invalid @enderror" placeholder="@lang('Bank Transfer')" value="{{ old('settings.bank_transfer', $settings['bank_transfer']) }}">
                                                        @error('bank_transfer')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Payout Fee')</label>
                                                        <input type="number" name="settings[payout_fee]" min="0" step="100" max="100000" class="form-control @error('payout_fee') is-invalid @enderror" placeholder="@lang('Payout Fee')" value="{{ old('settings.payout_fee', $settings['payout_fee']) }}">
                                                        @error('payout_fee')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('PPN') %</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[ppn]" min="0" step="0.1" max="100" class="form-control @error('ppn') is-invalid @enderror" placeholder="@lang('PPN')" value="{{ old('settings.ppn', $settings['ppn']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('ppn')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Credit Card') %</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[cc_percent]" min="0" step="0.1" max="100" class="form-control @error('cc_percent') is-invalid @enderror" placeholder="@lang('Credit Card')" value="{{ old('settings.cc_percent', $settings['cc_percent']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('cc_percent')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('Credit Card') Rp.</label>
                                                        <div class="input-group">
                                                            <input type="number" name="settings[cc_rp]" min="0" step="0.1" max="100000" class="form-control @error('cc_rp') is-invalid @enderror" placeholder="@lang('Credit Card')" value="{{ old('settings.cc_rp', $settings['cc_rp']) }}">
                                                            <span class="input-group-text" ><i class="ri-percent-line"></i></span>
                                                            @error('cc_rp')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer card-dark-80">
                                            <div class="form-group row align-items-end text-end">
                                                <div class="col-md-12">
                                                    <button type="submit" id="btn-submit" class="btn btn-primary">@lang('form.btn_submit')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        $(()=>{

        });
    </script>
@endsection