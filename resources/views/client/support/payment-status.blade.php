@extends('layouts.template-support')

@section('title', __('Payment Status') . ' | ' .$orderid)

@section('styles')
    <style>
        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loaders {
            border: 6px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #6103d0;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
        }

        .stamp {
            transform: rotate(-14deg);
            position: absolute;
            z-index: 2;
            width: 450px;
            min-height: 120px;
            top: 22rem;
            color: #555;
            font-size: 3rem;
            font-weight: 700;
            border: 0.25rem solid #555;
            display: inline-block;
            padding: 0.25rem 1rem;
            text-transform: uppercase;
            border-radius: 1rem;
            font-family: 'Courier';
            -webkit-mask-image: url('/template/images/grunge-stamp.png');
            -webkit-mask-size: 944px 604px;
            mix-blend-mode: multiply;
            text-align: center;
        }

        .is-success {
            color: #0a99294b;
            border: 0.5rem double #0a99294b;
            -webkit-mask-position: 2rem 3rem;
            font-size: 3rem;
        }

        .is-pending {
            color: #7c7c7c4b;
            border: 0.5rem double #7c7c7c4b;
            -webkit-mask-position: 2rem 3rem;
            font-size: 3rem;
        }

        .is-failed {
            color: #f74d5a4b;
            border: 0.5rem double #f74d5a4b;
            -webkit-mask-position: 2rem 3rem;
            font-size: 3rem;
        }

        .red-payemts {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 120px;
        }

        .text-invoice {
            letter-spacing: 0.18em;
            font-weight: 900;
        }

        @media (max-width: 425px) {
            .stamp {
                width: 350px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative pt-3 mt-5">
            <div class="row px-lg-5 px-3">
                <div class="col-12" data-aos="zoom-in-up" data-aos-duration="800">
                    <div class="card border-0 rounded shadow min-vh-100 card-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mt-3 mb-5 pb-3 border-bottom">
                                <a href="{{ route('home') }}">
                                    <img src="/template/images/omg.png" class="icon-60" alt="">
                                </a>
                                <div>
                                    <h1 class="text-primary text-invoice">INVOICE</h1>
                                </div>
                            </div>

                            <div id="paymentstatus" style="min-height:150px;"></div>

                            <div class="row">
                                <div class="col-12">
                                    <img src="/template/images/footer-payments.png" alt="" class="img-fluid" width="50%">
                                </div>
                                <div class="col-3 d-none d-md-block d-lg-block">
                                    <img src="/template/images/redpayments.png" alt="" class="img-fluid red-payemts">
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center align-items-center my-5">
                                <div class="col-xl-4 col-md-4 col-sm-12 py-1">
                                    <a href="javascript:history.back()" class="btn btn-danger rounded-pill w-100" style="z-index: 999;">Kembali</a>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-12 py-1">
                                    <button id="refresh" class="btn spinner btn-primary rounded-pill w-100" style="z-index: 999;">Refresh</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/payment-status-v2.1.js') }}" id="payment-status" data-id="{{ $orderid }}"></script>
@endsection
