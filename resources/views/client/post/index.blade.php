@extends('layouts.app')

@section('content')
<div class="container px-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Content') }}</div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ json_encode($data) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
