@extends('errors::default')

@section('title', StatusCode::getMessageForCode('503'))
@section('code', '503')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
