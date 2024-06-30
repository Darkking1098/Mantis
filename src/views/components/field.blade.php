{{ mantisCss(['mu-field', 'mu-field1']) }}
@if (!isset($fname) || in_array($fname, $fillable ?? [$fname]))
    <div class="mu-field mu-field1">
        <div class="field_wrap">
            @if (isset($label))
                <label for="{{ $fname }}">{{ $label }}</label>
            @endif
            <div class="input_wrapper">{{ $slot }}</div>
            {!! $info ?? '' !!}
        </div>
        @error($fname ?? '------')
            <p class="error"><i class="fa-solid fa-bug"></i> {{ $message }}</p>
        @enderror
    </div>
@endif
