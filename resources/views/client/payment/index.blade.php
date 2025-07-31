@extends('layouts.template-support')

@section('title')
    <title>Payment Status | {{ $orderid }}</title>
@endsection

@section('styles')

@endsection

@section('content')
<div class="container" style="height: 90vh;">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
       
            <div id="paymentstatus" class="card mt-5 mb-5 card border-0 rounded shadow-lg">
         
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script id="payment-status" data-id="{{ $orderid }}" type="text/javascript" src="{{asset('/template/js/payment-status.js')}}"></script>
@endsection