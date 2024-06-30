@if ($role::hasUrlPermit($url))
    <li class="menu_item error delete_btn" data-api="{{ $url }}">
        <i class="icon fa-solid fa-trash"></i>
        <span>Delete</span>
    </li>
@endif
