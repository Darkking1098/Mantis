@php
    $path = [
        ['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')],
        ['title' => 'Pages', 'link' => url('admin/page')],
        ['title' => 'Groups', 'link' => url('admin/page/group')],
    ];
    if (isset($group)) {
        $path = [
            ...$path,
            ['title' => 'Group - ' . $group['id'], 'link' => url('admin/page/group/' . $group['id'])],
            ['title' => 'Update Group'],
        ];
    } else {
        $path[] = ['title' => 'Create Page'];
    }
@endphp
@extends('Mantis::admin.assets.layout')
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.form>
            <section class="panel">
                <div class="section_info">
                    <h5 class="section_title">Group Basic Info</h5>
                    <p class="section_desc">Just normal things to create a new group</p>
                </div>
                <fieldset>
                    <x-Mantis::field fname="title" label="Group Title">
                        <input type="text" name="title" id="title" placeholder="Group Title"
                            value="{{ $group['title'] ?? '' }}" required>
                    </x-Mantis::field>
                    <x-Mantis::field fname="sort_order" label="Group Index">
                        <input type="number" name="sort_order" id="sort_order" required min="1"
                            placeholder="Group Index" value="{{ $group['sort_order'] ?? '' }}">
                    </x-Mantis::field>
                </fieldset>
            </section>
            <fieldset class="cflex">
                <x-Mantis::checkbox fname="status" :checked="$group['status'] ?? true" label="Group is available to use" />
            </fieldset>
        </x-Mantis::admin.form>
    </main>
@endsection
