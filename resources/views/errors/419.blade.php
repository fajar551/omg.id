@extends('errors::default')

@section('title', StatusCode::getMessageForCode('419'))
@section('code', '419')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
