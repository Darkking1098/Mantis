@php
    $path = [['title' => $admin['role']['title'] . ' Dashboard']];
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
                        <th>Role</th>
                        <th>Role Desc</th>
                        <th>Holders</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($roles as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $r['title'] }}</td>
                            <td>{{ $r['description'] }}</td>
                            <td>{{ $r['employees_count'] }}</td>
                            <td class="actions">
                                {{-- @include('Admin.assets.options.toggle_status', ['url' => route('Admin.Role.toggle', ["role" => $r['id']])]) --}}
                                @include('Mantis::admin.assets.options.update', [
                                    'url' => route('admin.role.update', ['role' => $r['id']]),
                                ])
                                @include('Mantis::admin.assets.options.delete', [
                                    'url' => route('admin.role.delete', ['role' => $r['id']]),
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
@endprepend
