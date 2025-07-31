@extends('errors::default')

@section('title', StatusCode::getMessageForCode('405'))
@section('code', '405')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
