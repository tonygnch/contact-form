@extends('layouts.app')

@section('content')
    <contact-component 
        title="Contact"
        submit-url="{{ route('contacts') }}">
    </contact-component>
@endsection
