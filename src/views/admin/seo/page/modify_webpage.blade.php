@php
    $path = [
        ['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')],
        ['title' => 'WebPages', 'link' => url('admin/page')],
    ];
    if (isset($webpage)) {
        $path = [
            ...$path,
            ['title' => 'WebPage - ' . $webpage['id'], 'link' => url('admin/page/' . $webpage['id'])],
            ['title' => 'Update Page'],
        ];
    } else {
        $path[] = ['title' => 'Create WebPage'];
    }
@endphp
@extends('Mantis::admin.assets.layout')
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.form>
            @include('Mantis::admin.seo.page.modify_webpage_component', [
                'webPage' => $webpage ?? [],
                'validate' => !isset($webpage),
            ])
        </x-Mantis::admin.form>
    </main>
@endsection
