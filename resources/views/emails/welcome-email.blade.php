@extends('emails.master')
@section('content')
<h1  style="font-size: 35px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'Arimo';" >{{ __('email.welcome.title', ["app_name" => env('APP_NAME')]) }}</h1>
<p  style="font-family: 'Arimo';  font-size: 14px; font-weight: normal; margin: 0;" >{{ isset($name) ? __('email.greeting_user', ["user" => $name]) : __('email.greeting') }}</p>
<p style="font-family: 'Arimo';  font-size: 14px; font-weight: normal; margin: 0;" >{{ __('email.welcome.paragraph_1', ["app_name" => env('APP_NAME')]) }}</p>
<div style="text-align: center; margin: 30px 0;">
    <a class="btn btn-primary"  href="{!! route('home') !!}" target="_blank"  style=" font-weight: 400; line-height: 1.5; color: #212529; text-align: center; text-decoration: none; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; user-select: none; background-color: transparent; border: 1px solid transparent; padding: 0.375rem 0.75rem;
    font-size: 14px;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    text-transform: capitalize;
    padding: 10px 20px;
    background-color: #6103D0;
border-color: #6103D0;
color: #fff;">{{ __('email.welcome.button_1') }}</a>
</div>
<p style="font-family: 'Arimo';  font-size: 14px; font-weight: normal; margin-bottom: 15px;">{{ __('email.welcome.paragraph_2', ["app_name" => env('APP_NAME')]) }}</p>
{{-- <a href="mailto:support@omg.id" target="_blank" class="text-break" style="color: #6103D0; text-decoration: underline; margin-bottom: 15px;"  >support@omg.id</a> --}}

<p  style="font-family: 'Arimo';  font-size: 14px; font-weight: normal; margin-top: 30px; margin-bottom: 15px;">{{ __('email.do_not_reply') }}</p>
<p style="font-family: 'Arimo';  font-size: 14px; font-weight: normal; margin-bottom: 8px;">{{ __('email.regards') }}</p>
<p  style="font-family: 'Arimo';  font-size: 14px; font-weight: bold; margin-bottom: 10px;">{{ __('email.regards_sender') }}</p>

{{-- <h2 style="font-size: 30px; font-weight: 700;  text-transform: capitalize; color: #6103D0; font-family: 'Arimo';" >Any question or help?</h2> --}}
{{-- <p><a href="{{ env('APP_URL', '#') }}" target="_blank" style="color: #6103D0; text-decoration: underline; margin-bottom: 10px;" >Visit this link</a></p> --}}
@endsection
