<label for="{{ $fname }}" class="checkbox_field">
    <input type="checkbox" name="{{ $fname }}" id="{{ $fname }}" value="1" @checked($checked ?? false)>
    <span>{{ $label ?? $slot }}</span>
</label>
