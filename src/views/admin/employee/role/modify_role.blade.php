@php
    $path = [['title' => $admin['role']['title'] . ' Dashboard']];
@endphp
@extends('Mantis::admin.assets.layout')
@prepend('css')
    <style>
        .permissions:not(:last-of-type) {
            margin-bottom: 20px;
        }

        .permission {
            font-size: 0.7em;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .permission span {
            display: inline-block;
            margin-left: 7px;
        }
    </style>
@endprepend
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.form>
            <section class="panel">
                <fieldset class="cflex">
                    <x-Mantis::field fname="title" label="Role Title">
                        <input type="text" name="title" id="title" value="{{ $role['title'] ?? '' }}" placeholder="Role Title">
                    </x-Mantis::field>
                    <x-Mantis::field fname="description" label="Role Description">
                        <input type="text" name="description" id="description" value="{{ $role['description'] ?? '' }}" placeholder="Role Description">
                    </x-Mantis::field>
                </fieldset>
            </section>
            <section class="panel">
                <fieldset class="cflex">
                    <fieldset class="permissions">
                        <label class="permission" for="per_master">
                            <input type="checkbox" name="permissions[]" id="per_master" value="*" @checked(($role['permissions'][0] ?? 'x') == '*')/>
                            <span>Master Access</span>
                        </label>
                    </fieldset>
                    @foreach ($groups as $i => $group)
                        @if (count($group['pages']))
                            <fieldset class="permissions">
                                @foreach ($group['pages'] as $j => $page)
                                    <label class="permission" for="per{{ $i }}_{{ $j }}">
                                        <input type="checkbox" name="permissions[]"
                                            id="per{{ $i }}_{{ $j }}" value="{{ $page['id'] }}"
                                            @checked(in_array($page['id'], $role['permissions'] ?? []))>
                                        <span>{{ $page['title'] }}</span>
                                    </label>
                                @endforeach
                            </fieldset>
                        @endif
                    @endforeach
                </fieldset>
            </section>
        </x-Mantis::admin.form>
    </main>
@endsection
@prepend('js')
@endprepend
