@extends('Mantis::layout.raw')
@section('styles')
    <link rel="stylesheet" href="{{ url('css/mantis.css') }}">
    <link rel="stylesheet" href="{{ url('mantis/icon/css/all.min.css') }}">
    @stack('css')
@endsection
@section('body')
    <body @class($body_class ?? [])>
        @yield('layout')
        @stack('others')
        <script src="{{ url('js/mantis.js') }}"></script>
        @stack('js')
    </body>
@endsection
