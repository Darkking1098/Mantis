@php
    $path = [['title' => $admin['role']['title'] . ' Dashboard']];
@endphp
@extends('Mantis::admin.assets.layout')
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <form>
            <div class="form_info">
                <div class="title cflex" style="gap: 10px;margin-bottom:15px;">
                    <p><span class="h2">{{ $query['name'] }}</span></p>
                    <p>{{ $query['email'] }}</p>
                </div>
            </div>
            <section class="panel">
                {{ $query['message'] }}
            </section>
        </form>
    </main>
@endsection
