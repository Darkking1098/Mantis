@php
    $path = [['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'All WebPages']];
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
                        <th>Page Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($webpages as $i => $page)
                        <tr @class(['disabled' => !$page['status']])>
                            <th class="min">{{ $i + 1 }}</th>
                            <td>{{ $page['title'] }}</td>
                            <td><a href="{{ url($page['slug']) }}">
                                    {{ $page['slug'] }}</a>
                            </td>
                            <td class="actions">
                                <i class="icon fa-solid fa-list-ul menu_btn">
                                    <menu>
                                        @include('Mantis::admin.assets.options.toggle_status', [
                                            'url' => route('admin.webpage.toggle', ['webpage' => $page['id']]),
                                        ])
                                        @include('Mantis::admin.assets.options.update', [
                                            'url' => route('admin.webpage.update', ['webpage' => $page['id']]),
                                        ])
                                        @include('Mantis::admin.assets.options.delete', [
                                            'url' => route('admin.webpage.delete', ['webpage' => $page['id']]),
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
