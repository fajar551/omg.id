@extends('errors::default')

@section('title', StatusCode::getMessageForCode('500'))
@section('code', '500')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
