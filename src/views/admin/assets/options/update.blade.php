@if ($role::hasUrlPermit($url))
    <a href="{{ $url }}" class="mu-link menu_item aic">
        <i class="icon fa-solid fa-edit"></i>
        <span>Update</span>
    </a>
@endif
