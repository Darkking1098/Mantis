@extends('Mantis::admin.assets.layout')
@prepend('css')
    <style>
        .stats {
            gap: 20px;
        }

        .stat {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px 0 #00000033;
        }
    </style>
@endprepend
@section('main')
    <main>
        {{ mantisCss(['mu-container-columns']) }}
        <div class="mu-grid-columns stats">
            <div class="ccol-6 ccol-s-4 ccol-m-3 stat"></div>
            <div class="ccol-6 ccol-s-4 ccol-m-3 stat"></div>
            <div class="ccol-6 ccol-s-4 ccol-m-3 stat"></div>
            <div class="ccol-6 ccol-s-4 ccol-m-3 stat"></div>
        </div>
    </main>
@endsection
