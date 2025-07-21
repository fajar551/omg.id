@extends('layouts.template-home')

@section('title', __('Bantuan'))

@section('styles')
    <style>
        .dark {
            color: #fff;
        }

        p {
            text-align: justify;
        }
    </style>
@endsection

@section('content')

<div class="container-fluid bg-heros   ">
    <div class=" position-absolute top-0 " style="margin-top: 200px; overflow: hidden; left: 0; right: 0;">
        <div class="container">
            <h2 class="text-white fw-semibold"> Career </h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="ro mt-5">
        <div class="card-body">

            <h3 class="fw-semibold  mb-4 mt-4">Front End Developer </h3>
            <h5 class="fw-semibold  mb-4 mt-4">Syarat </h5>
            <ul>
                <li>
                Bisa Front End
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')

@endsection