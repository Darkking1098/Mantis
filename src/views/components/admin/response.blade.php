@once
    @prepend('css')
        <style>
            .mu-response {
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.8em;
                margin-bottom: 20px;
            }

            .mu-response i.icon {
                width: 38px;
                font-size: 1.1em;
            }
        </style>
    @endprepend
@endonce
@if (Session::has('result'))
    @php
        $icon = [
            'success' => 'fa-check',
            'error' => 'fa-bug',
            'warn' => 'fa-triangle-exclamation',
            'info' => 'fa-info',
        ];
        $type = Session::get('result')['success'] ? 'success' : 'error';
    @endphp
    <div class="mu-response {{ $type }} bdr-{{ $type }} bg-{{ $type }}">
        <i @class(['fa-solid icon', $icon[$type]])></i>
        {{ Session::get('result')['error'] ?? Session::get('result')['msg'] }}
    </div>
    {!! $actions ?? '' !!}
@endif
