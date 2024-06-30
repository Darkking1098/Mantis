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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Query</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($queries as $i => $query)
                        <tr>
                            <th class="min">{{ $i + 1 }}</th>
                            <td><a href="{{ route('admin.query.view', ['query' => $query['id']]) }}">{{ $query['name'] }}</td>
                            <td>{{ $query['email'] }}</td>
                            <td>{{ $query['subject'] }}</td>
                            <td>{{ $query['message'] }}</td>
                            <td>
                                @include('Mantis::admin.assets.options.delete', [
                                    'url' => route('admin.query.delete', ['query' => $query['id']]),
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-Mantis::admin.table>
    </main>
@endsection
