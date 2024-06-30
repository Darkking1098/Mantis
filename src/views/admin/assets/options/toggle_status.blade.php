@if ($role::hasUrlPermit($url))
    @prependOnce('css')
        <style>
            tr:not(.disabled) .fa-eye-slash,
            tr.disabled .fa-eye {
                display: none;
            }
        </style>
    @endPrependOnce
    <li class="toggle_btn menu_item" data-api="{{ $url }}">
        <i class="icon fa-solid fa-eye"></i>
        <i class="icon fa-solid fa-eye-slash"></i>
        <span>Toggle Status</span>
    </li>
@endif
