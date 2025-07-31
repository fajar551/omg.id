@extends('errors::default')

@section('title', StatusCode::getMessageForCode('404'))
@section('code', '404')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
