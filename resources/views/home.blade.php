@extends('layouts.app')

@section('content')
    <home-component
        title="{{ __('Dashboard') }}"
        status="{{ session('status') }}"
        content="{{ __('You are logged in!') }}"
        contacts-route="{{ route('contacts') }}"
        contacts-button-title="{{ __('Contact') }}">
    </home-component>
@endsection
