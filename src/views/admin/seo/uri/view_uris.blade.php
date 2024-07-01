@php
    $path = [['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'All Weburis']];
@endphp
@extends('Mantis::admin.assets.layout')
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.table>
            @slot('thead')
                <thead>
                    <tr>
                        <th class="min">Sr.</th>
                        <th>Uri</th>
                        <th>State</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($weburis as $i => $uri)
                        <tr @class(['disabled' => !$uri['status']])>
                            <th class="min">{{ $i + 1 }}</th>
                            <td><a href="{{ url($uri['uri']) }}">
                                    {{ $uri['uri'] }}</a>
                            </td>
                            <td>{{ $uri['state'] }}</td>
                            <td class="actions">
                                <i class="icon fa-solid fa-list-ul menu_btn">
                                    <menu>
                                        @include('Mantis::admin.assets.options.toggle_status', [
                                            'url' => route('ajax.admin.weburi.toggle', $uri['id']),
                                        ])
                                        @include('Mantis::admin.assets.options.update', [
                                            'url' => route('admin.weburi.update', $uri['id']),
                                        ])
                                        @include('Mantis::admin.assets.options.delete', [
                                            'url' => route('ajax.admin.weburi.delete', $uri['id']),
                                        ])
                                    </menu>
                                </i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-Mantis::admin.table>
    </main>
@endsection
