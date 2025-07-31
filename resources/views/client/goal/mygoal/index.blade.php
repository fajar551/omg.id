@extends('layouts.template-body')

@section('title')
    <title>@lang('page.my_goal')</title>
@endsection

@section('styles')
    <style>
        .acard {
            color: whitesmoke;
        }

        /* a#button-edit-my-goal {
            padding: 10px 100px;
            font-size: 14px;
        } */
        .bg-warning {
            background-color: #d0ee26 !important;
        }

        .progress-bar-striped {
            background-image: linear-gradient(331deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
            background-size: 5rem 3rem;
        }

        .btn-my-goal .btn {
            width: 160px;
            font-size: 13px;
        }

        @media(max-width:768px) {
            .btn-my-goal .btn {
                width: unset;
                font-size: 12px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container px-5  ">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.my_goal'), 
                    'pages' => [
                        '#' => __('page.menu_goal'),
                    ]
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 d-none  d-lg-block">
                @include('components.nav-goal')
            </div>
            <div class="col d-lg-none  ">
                @include('components.nav-goal-mobile')
            </div>
        </div>

        <div class="step14">
            @if (empty($goal))
                @include('components.is-empty-data', [
                    'message' => 'Anda belum memiliki Goal',
                    'text' => '',
                    'link' => [
                        [
                            'url' => route('goal.mygoal.create'),
                            'icon' => '<i class="las la-plus-circle"></i>',
                            'title' => __('form.btn_create_goal'),
                        ],
                    ],
                ])
            @else
                <div class="goal-section" style="margin-bottom: 200px;">
                    @include('components.goal-card', ['goal' => $goal, 'goalProgress' => $goalProgress])
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/guide/goal.js') }}"></script>
    <script type="text/javascript">
        /**
        * My goal index script
        * Version: 1.0
        */
        (function($) {

            $(document).on('click', '#set-reached', function() {
                ToastConfirm.fire({
                    title: "@lang('page.are_you_sure')",
                    html: "@lang('page.sure_set_reached_goal')",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(el).attr({ "disabled": true }).html("@lang('page.loading')");
                        $('#set-reached-form').submit();
                    }
                }).catch(swal.noop);
            })
        })(jQuery);
    </script>
@endsection
