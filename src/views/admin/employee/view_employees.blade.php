@php
    $path = [['title' => $admin['role']['title'] . ' Dashboard']];
@endphp
@extends('Mantis::admin.assets.layout')
@prepend('css')
@endprepend
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.table>
            @slot('thead')
                <thead>
                    <tr>
                        <th class="min">Sr.</th>
                        <th>Name<br><i class="text">Username</i></th>
                        <th>Role</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($employees as $i => $emp)
                        <tr @class(['disabled' => !$emp['status']])>
                            <th class="min">{{ $i + 1 }}</th>
                            <td>{{ $emp['name'] }}<br><i class="text">{{ $emp['username'] }}</i></td>
                            <td>{{ $emp['role']['title'] }}</td>
                            <td>{{ $emp['salary'] ?? 0 }}</td>
                            <td class="actions">
                                <i class="icon fa-solid fa-list-ul menu_btn">
                                    <menu> @include('Mantis::admin.assets.options.toggle_status', [
                                        'url' => route('ajax.admin.employee.toggle', $emp['id']),
                                    ])
                                        @include('Mantis::admin.assets.options.update', [
                                            'url' => route('admin.employee.update', $emp['id']),
                                        ])
                                        @include('Mantis::admin.assets.options.delete', [
                                            'url' => route('ajax.admin.employee.delete', $emp['id']),
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
