@php
    $path = [
        ['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')],
        ['title' => 'Pages', 'link' => url('admin/page')],
    ];
    if (isset($page)) {
        $path = [
            ...$path,
            ['title' => 'Page - ' . $page['id'], 'link' => url('admin/page/' . $page['id'])],
            ['title' => 'Update Page'],
        ];
    } else {
        $path[] = ['title' => 'Create Page'];
    }
@endphp
@extends('Mantis::admin.assets.layout')
@prepend('css')
    <style>
        .mu-field .input_wrapper i {
            width: 38px;
            color: var(--error);
            cursor: pointer;
            font-size: 0.85em;
        }
    </style>
@endprepend
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.form>
            <section class="panel">
                <div class="section_info">
                    <h5 class="section_title">Page Basic Info</h5>
                    <p class="section_desc">Just normal things to create a new page</p>
                </div>
                <fieldset class="cflex">
                    <fieldset>
                        <x-Mantis::field fname="uri" label="Page URI">
                            <input type="text" name="uri" id="uri" placeholder="Page URI"
                                value="{{ $page['uri'] ?? 'admin/' }}" required>
                        </x-Mantis::field>
                        <x-Mantis::field fname="title" label="Page Title"> <input type="text" name="title"
                                id="title" placeholder="Page Title" value="{{ $page['title'] ?? '' }}" required>
                        </x-Mantis::field>
                    </fieldset>
                    <fieldset>
                        <x-Mantis::field fname="group" label="Page Group">
                            <select name="group" id="group">
                                @foreach ($groups as $group)
                                    <option value="{{ $group['id'] }}" @selected($group['id'] == ($page['group'] ?? 0))>
                                        {{ $group['title'] }}</option>
                                @endforeach
                            </select>
                        </x-Mantis::field>
                        @php
                            $panels = [['admin', 'Admin Panel']];
                        @endphp
                        <x-Mantis::field fname="panel" label="Page Panel">
                            <select name="panel" id="panel">
                                @foreach ($panels as $panel)
                                    <option value="{{ $panel[0] }}" @selected(($page['panel'] ?? 'admin') == $panel[0])>{{ $panel[1] }}
                                    </option>
                                @endforeach
                            </select>
                        </x-Mantis::field>
                    </fieldset>
                </fieldset>
            </section>
            <section class="panel">
                <div class="section_info">
                    <h5 class="section_title">Page Inner Permits</h5>
                    <p class="section_desc">Permissions used inside page</p>
                </div>
                <fieldset class="cflex">
                    @foreach ($page['inner_permits'] ?? [] as $i => $permit)
                        <x-Mantis::field fname="inner_permit{{ $i }}" label="Permit {{ $i }}">
                            <input type="text" name="inner_permits[]" id="inner_permit{{ $i }}"
                                placeholder="Permit name" required value="{{ $permit }}">
                            <i class="icon fa-solid fa-xmark" onclick="remove_permit($(this))"></i>
                        </x-Mantis::field>
                    @endforeach
                    <button type="button" class="mu-btn" id="create_permit">Create Permission</button>
                </fieldset>
            </section>
            <fieldset class="cflex">
                <x-Mantis::checkbox fname="permission_required" :checked="$page['permission_required'] ?? true"
                    label="Permission is required to access this page" />
                <x-Mantis::checkbox fname="visible" :checked="$page['visible'] ?? false" label="Display page in sidebar" />
                <x-Mantis::checkbox fname="status" :checked="$page['status'] ?? true" label="Page is available to use" />
            </fieldset>
        </x-Mantis::admin.form>
    </main>
    {{ mantisJs('MTemplate') }}
    <template id="inner_permit">
        <x-Mantis::field fname="inner_permit{id}" label="Permit {id}">
            <input type="text" name="inner_permits[]" id="inner_permit{id}" placeholder="Permit name" required>
            <i class="icon fa-solid fa-xmark" onclick="remove_permit($(this))"></i>
        </x-Mantis::field>
    </template>
@endsection
@prepend('js')
    <script>
        $('#create_permit').addEventListener('click', function() {
            let id = this.MU.get('data-count') ?? 0;
            this.MU.set('data-count', ++id);
            this.MU.insert(0, $('#inner_permit').MU.passParams({
                id
            }));
        })

        function remove_permit(node) {
            node.closest('.mu-field').remove();
        }
    </script>
@endprepend
