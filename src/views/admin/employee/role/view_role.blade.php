@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard']];
@endphp
@extends('Mantis::admin.assets.layout')
@prepend('css')
@endprepend
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
    </main>
@endsection
@prepend('js')
@endprepend
