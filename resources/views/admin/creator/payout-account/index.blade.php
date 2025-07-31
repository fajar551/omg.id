@extends('layouts.admin.omg')

@section('title',  __('Manage Creator - Payout Account'))

@section('styles')
    <style>
        /* .modal-dialog {
            width: 100% !important;
            height: 100% !important;
            margin: 0;
            padding: 0;
        }
        
        .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        } */
    </style>
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
                       <li class="breadcrumb-item">@lang('Manage Creator')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('Payout Account')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Payout Account')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="#" type="button" class="btn btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-search"></i> Cekrekening.id</a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav tab-nav-pane nav-tabs  mb-0">
                                <li class="pb-0 mb-0 nav-item"><a data-bs-toggle="tab" data-bs-target="#Verivied" class="font-weight-bold text-uppercase ms-3 active" href="#Verivied">Not Verified</a>
                                    @if (sizeof($inactive_account)>0)
                                        <span class="me-3 iq-notify bg-soft-danger rounded p-1">{{ sizeof($inactive_account) }}</span>
                                    @endif
                                </li>
                                <li class="pb-0 mb-0 nav-item"><a data-bs-toggle="tab" data-bs-target="#NotVerivied" class="font-weight-bold text-uppercase ms-3" href="#NotVerivied">Verified</a></li>
                                </ul>
                                <div class="tab-pane fade show active" id="Verivied" role="tabpanel">
                                    <div class="row">
                                        @if (sizeof($inactive_account)>0)
                                            @foreach ($inactive_account as $item)
                                            <div class="col-lg-3 mb-6">
                                                <div class="card card-dark-80 mt-4">
                                                    <div class="card-body">                                                    
                                                        <div class="">
                                                            <div class="user-img me-2">
                                                                <img src="{{ $item->user->profile_picture ? route('api.profile.preview', ['file_name' => $item->user->profile_picture]) : asset('template/images/user/user.png') }}" alt="userimg" class="avatar-40 rounded-circle">  <span style="font-size: 20px">{{ $item->user->username }}</span>
                                                            </div>
                                                            <div class="borderbox1 d-flex align-items-center flex-wrap">
                                                                <h6>{{ strtoupper($item['channel_code']) }}</h6>
                                                            </div>
                                                            <div class="borderbox1 d-flex align-items-center flex-wrap">
                                                                <h6>{{ $item['account_name'] }}</h6> <button type="button" class="btn btn-outline-primary mb-1 ms-2" data-clipboard-text="{{ $item['account_name'] }}" data-toggle="tooltip" title="Copied!"><i class="las la-copy"></i></button>
                                                            </div>
                                                            <div class="borderbox1 d-flex align-items-center flex-wrap">
                                                                <h6>{{ $item['account_number'] }}</h6> <button type="button" class="btn btn-outline-primary mb-1 ms-2" data-clipboard-text="{{ $item['account_number'] }}" data-toggle="tooltip" title="Copied!"><i class="las la-copy"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer card-dark-80">
                                                        <button type="button" class="btn btn-outline-warning btn-block mt-2" data-id="{{ $item['id'] }}" style="width:100%" onclick="setVerifiedConfirm(this)"><i class="las la-flag-checkered"></i> Set Verified</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <form action="{{ route('admin.creator.payoutaccount.setverified') }}" method="POST" id="set-verified-form" hidden >
                                                @csrf
                                                <input type="hidden" name="id" id="setprimary-id" required/>
                                            </form>
                                        @else
                                            <center>
                                                <h3>Empty</h3>
                                            </center>
                                        @endif
                                        
                                    </div>
                                    <div class="d-flex justify-content-end p-4">
                                        <div class="">{!! $inactive_account->links() !!}</div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="NotVerivied" role="tabpanel">
                                    <div class="row">
                                        @foreach ($active_account as $item)
                                        <div class="col-lg-3 mb-6">
                                            <div class="card card-dark-80 mt-4">
                                                <div class="card-body">                                                    
                                                    <div class="">
                                                        <div class="user-img me-2">
                                                            <img src="{{ $item->user->profile_picture ? route('api.profile.preview', ['file_name' => $item->user->profile_picture]) : asset('template/images/user/user.png') }}" alt="userimg" class="avatar-40 rounded-circle">  <span style="font-size: 20px">{{ $item->user->username }}</span>
                                                        </div>
                                                        <div class="borderbox1 d-flex align-items-center flex-wrap">
                                                            <h6>{{ strtoupper($item['channel_code']) }}</h6>
                                                        </div>
                                                        <div class="borderbox1 d-flex align-items-center flex-wrap">
                                                            <h6 onclick="copy(this)">{{ $item['account_name'] }}</h6>
                                                        </div>
                                                        <div class="borderbox1 d-flex align-items-center flex-wrap">
                                                            <h6>{{ $item['account_number'] }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex justify-content-end p-4">
                                        <div class="">{!! $active_account->links() !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Cekrekening.id</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                 
                 </button>
              </div>
              <div class="modal-body">
                <iframe src="https://cekrekening.id/home-card"
                    frameborder="0" 
                    marginheight="0" 
                    marginwidth="0" 
                    width="100%" 
                    height="500" 
                    scrolling="auto"></iframe >
              </div>
           </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('template/vendor/clipboard/dist/clipboard.min.js')}}"></script>
    <script type="text/javascript">
        $(()=>{
            var clipboard = new ClipboardJS('.btn');
            // clipboard.on('success', function(e) {
            //     $('[data-toggle="tooltip"]').tooltip("show");
            // });
        });
        const setVerifiedConfirm = (el) => {
            const id = $(el).attr("data-id");
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                html: "{!! __('You will set this account as <cite>\"Verified?\"</cite>') !!}",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "{{ __('OK') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(el).attr({"disabled": true}).html("Loading...");
                    $('#setprimary-id').val(id);
                    $('#set-verified-form').submit();
                }
            }).catch(swal.noop);
        }

    </script>
@endsection