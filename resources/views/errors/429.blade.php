@extends('errors::default')

@section('title', StatusCode::getMessageForCode('429'))
@section('code', '429')
@section('message')
    {!! __(config('app.debug') ? $exception->getMessage() : 'An error occured') !!}
@endsection
