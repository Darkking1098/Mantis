@php
    $path = [
        ['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')],
        ['title' => 'Pages', 'link' => url('admin/page')],
        ['title' => 'All Groups'],
    ];
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
                        <th>Group Title</th>
                        <th>Group Index</th>
                        <th>Group Pages</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($groups as $i => $group)
                        <tr @class(['disabled' => !$group['status']])>
                            <th class="min">{{ $i + 1 }}</th>
                            <td>{{ $group['title'] }}</td>
                            <td>{{ $group['sort_order'] }}</td>
                            <td><a href="{{ url('admin/page?group=' . $group['id']) }}">{{ $group['pages_count'] }} Pages</a>
                            </td>
                            <td class="actions">
                                @include('Mantis::admin.assets.options.toggle_status', ['url' => route('admin.protected.group.toggle', ["group" => $group['id']])])
                                @include('Mantis::admin.assets.options.update', ['url' => route('admin.protected.group.update', ["group" => $group['id']])])
                                @include('Mantis::admin.assets.options.delete', ['url' => route('admin.protected.group.delete', ["group" => $group['id']])])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-Mantis::admin.table>
    </main>
@endsection
