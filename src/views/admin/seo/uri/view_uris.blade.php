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
                                @include('Mantis::admin.assets.options.toggle_status', ['url' => route('admin.weburi.toggle', ["weburi" => $uri['id']])])
                                @include('Mantis::admin.assets.options.update', ['url' => route('admin.weburi.update', ["weburi" => $uri['id']])])
                                @include('Mantis::admin.assets.options.delete', ['url' => route('admin.weburi.delete', ["weburi" => $uri['id']])])
                                @include('Mantis::admin.assets.options.show_extra')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-Mantis::admin.table>
    </main>
@endsection
