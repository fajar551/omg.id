@extends('errors::default')

@section('title', StatusCode::getMessageForCode('401'))
@section('code', '401')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
