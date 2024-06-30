@php
    $path = [
        ['title' => $admin['role']['title'] . ' Dashboard', 'link' => url('admin')],
        ['title' => 'Weburi', 'link' => url('admin/weburi')],
    ];
    if (isset($weburi)) {
        $path = [
            ...$path,
            ['title' => 'Weburi - ' . $weburi['id'], 'link' => url('admin/weburi/' . $weburi['id'])],
            ['title' => 'Update uri'],
        ];
    } else {
        $path[] = ['title' => 'Create Weburi'];
    }
@endphp
@extends('Mantis::admin.assets.layout')
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.form>
            <section class="panel">
                <div class="section_info">
                    <h5 class="section_title">Uri Basic Info</h5>
                    <p class="section_desc">Just normal things for uri</p>
                </div>
                <fieldset class="cflex">
                    <fieldset>
                        <x-Mantis::field fname="uri" label="URI">
                            <input type="text" name="uri" id="uri" placeholder="URI" @readonly(isset($weburi['uri']))
                                value="{{ $weburi['uri'] ?? '' }}" required>
                        </x-Mantis::field>
                        @php
                            $states = [['dev', 'Development'], ['test', 'Testing'], ['prod', 'Production']];
                        @endphp
                        <x-Mantis::field fname="state" label="Uri State">
                            <select name="state" id="state">
                                @foreach ($states as $state)
                                    <option value="{{ $state[0] }}" @selected($state[0] == ($weburi['state'] ?? 'dev'))>{{ $state[1] }}
                                    </option>
                                @endforeach
                            </select>
                        </x-Mantis::field>
                    </fieldset>
                </fieldset>
            </section>
            <fieldset class="cflex">
                <x-Mantis::checkbox fname="status" :checked="$weburi['status'] ?? true" label="Uri is available to use" />
            </fieldset>
        </x-Mantis::admin.form>
    </main>
@endsection
@if (!($weburi ?? ''))
    @prepend('js')
        <script>
            $('form')[0].addEventListener('submit', (e) => {
                ajax({
                    url: "{{ route('admin.weburi.check') }}",
                    async: false,
                    data: {
                        uri: $('#uri').value
                    },
                    success: (res) => {
                        res = JSON.parse(res);
                        if (res.isExist) {
                            e.preventDefault();
                            alert("Uri already present !!!");
                        }
                    }
                });
            });
        </script>
    @endprepend
@endif
