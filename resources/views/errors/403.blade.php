@extends('errors::default')

@section('title', StatusCode::getMessageForCode('403'))
@section('code', '403')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
