@extends('layouts.base')

@section('title', $title ?? '')
@section('bodyClass', $bodyClass ?? '')

@section('content')
    @includeIf('components.layouts.header')
    @if(session('success'))
        <div class="container my-large">
            <div class="success-message">   
                {{ session('success') }}
            </div>
        </div>
    @endif
    @yield('content')
@endsection
