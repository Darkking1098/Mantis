@extends('Mantis::layout.mantis', [
    'meta_required' => false,
    'title' => ($admin['admin_role']['role_title'] ?? 'Master') . ' Panel',
    'keywords' => 'Admin keywords',
    'description' => 'Admin description',
])
@prepend('css')
    <link rel="stylesheet" href="{{ url('css/admin.css') }}">
@endprepend
@push('meta')
    <meta organization="Mantis" />
    <meta panel="Mantis" />
@endpush
@section('layout')
    <x-Mantis::popup></x-Mantis::popup>
    <x-Mantis::admin.loader></x-Mantis::admin.loader>
    <div class="mu-layout mu-sidebar-layout">
        @include('Mantis::admin.assets.sidebar')
        <div class="main_content">
            @includeIf('Mantis::admin.assets.header')
            <div class="container-xxl" style="flex-grow: 1">
                @yield('main')
            </div>
            @includeIf('Mantis::admin.assets.footer')
        </div>
    </div>
@endsection
