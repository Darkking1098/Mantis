@php
    $path = [
        ['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')],
        ['title' => 'View all Pages'],
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
                        <th>Page Title</th>
                        <th>Page Group</th>
                        <th>Page URI</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($pages as $i => $page)
                        <tr @class(['disabled' => !$page['status']]) data-group="{{ $page['page_group']['id'] }}">
                            <th class="min">{{ $i + 1 }}</th>
                            <td>{{ $page['title'] }}</td>
                            <td>
                                <a href="{{ url('admin/page/group/' . $page['page_group']['id']) }}">
                                    {{ $page['page_group']['title'] }}
                                </a>
                            </td>
                            <td>{{ $page['uri'] }}</td>
                            <td class="actions">
                                @include('Mantis::admin.assets.options.toggle_status', [
                                    'url' => route('admin.protected.page.toggle', ['page' => $page['id']]),
                                ])
                                @include('Mantis::admin.assets.options.update', [
                                    'url' => route('admin.protected.page.update', ['page' => $page['id']]),
                                ])
                                @include('Mantis::admin.assets.options.delete', [
                                    'url' => route('admin.protected.page.delete', ['page' => $page['id']]),
                                ])
                                @include('Mantis::admin.assets.options.show_extra')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-Mantis::admin.table>
    </main>
@endsection
@prepend('js')
    <script>
        let url = new URLSearchParams(location.search);
        if (url.has('group')) {
            let g = url.get('group');
            $('tbody tr').perform((x) => {
                if (x.get('data-group') != g) x.addClass('hide');
            })
        }
    </script>
@endprepend
